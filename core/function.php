<?php


// Add custom avatar field to user profile
add_action('show_user_profile', 'add_custom_avatar_field');
add_action('edit_user_profile', 'add_custom_avatar_field');
function add_custom_avatar_field($user)
{
    $avatar_url = get_user_meta($user->ID, 'custom_avatar', true);
?>
    <h3><?php _e("Custom Avatar", "nebon"); ?></h3>
    <table class="form-table">
        <tr>
            <th><label for="custom_avatar"><?php echo esc_html__( "Upload Avatar", "nebon" ); ?></label></th>
            <td>
                <input type="text" name="custom_avatar" id="custom_avatar" value="<?php echo esc_url($avatar_url); ?>" class="regular-text" />
                <input type="button" class="button button-secondary" value="Choose Image" id="custom_avatar_upload_btn" />
                <br>
                <img src="<?php echo esc_url($avatar_url); ?>" style="max-width: 100px; margin-top: 10px;" id="custom_avatar_preview">
            </td>
        </tr>
    </table>
<?php
}

add_action('personal_options_update', 'save_custom_avatar_field');
add_action('edit_user_profile_update', 'save_custom_avatar_field');
function save_custom_avatar_field($user_id)
{
    if (current_user_can('edit_user', $user_id)) {
        update_user_meta($user_id, 'custom_avatar', esc_url_raw($_POST['custom_avatar']));
    }
}

add_action('admin_enqueue_scripts', function ($hook) {
    if ($hook === 'profile.php' || $hook === 'user-edit.php') {
        wp_enqueue_media();
        wp_enqueue_script('jquery');

        wp_add_inline_script('jquery', <<<JS
            jQuery(document).ready(function($) {
                $('#custom_avatar_upload_btn').on('click', function(e) {
                    e.preventDefault();
                    const frame = wp.media({
                        title: 'Select or Upload Avatar',
                        button: { text: 'Use this image' },
                        multiple: false
                    });
                    frame.on('select', function() {
                        const attachment = frame.state().get('selection').first().toJSON();
                        $('#custom_avatar').val(attachment.url);
                        $('#custom_avatar_preview').attr('src', attachment.url);
                    });
                    frame.open();
                });
            });
        JS);
    }
});

add_filter('get_avatar_url', 'tache_custom_avatar_url', 10, 3);
function tache_custom_avatar_url($url, $id_or_email, $args)
{
    $user = false;

    if (is_numeric($id_or_email)) {
        $user = get_user_by('id', $id_or_email);
    } elseif (is_object($id_or_email) && isset($id_or_email->user_id)) {
        $user = get_user_by('id', $id_or_email->user_id);
    } elseif (is_string($id_or_email)) {
        $user = get_user_by('email', $id_or_email);
    }

    if ($user) {
        $custom = get_user_meta($user->ID, 'custom_avatar', true);
        if (!empty($custom)) {
            return esc_url($custom);
        }
    }

    return $url;
}

add_action('admin_head', function () {
    $screen = get_current_screen();
    if ($screen && in_array($screen->id, ['profile', 'user-edit'])) {
        echo '<style>
            .user-profile-picture,
            tr.user-profile-picture {
                display: none !important;
            }
        </style>';
    }
});

function t888_output_custom_color_variables()
{
    $color1_main   = get_theme_mod('t888_main_color1', '#000000');
    $color1_switch = get_theme_mod('t888_main_color1-switch', '#cccccc');
    $color2_main   = get_theme_mod('t888_main_color2', '#b88166');
    $color2_switch = get_theme_mod('t888_main_color2_switch', '#ffde00');

    echo '<script>';
    echo 'window.t888ThemeColors = ' . json_encode([
        'primary'         => $color1_main,
        'primary_switch'  => $color1_switch,
        'secondary'       => $color2_main,
        'secondary_switch' => $color2_switch,
    ], JSON_UNESCAPED_SLASHES) . ';';
    echo '</script>';
}
add_action('wp_head', 't888_output_custom_color_variables');




function t888_get_free_shipping_rule_for_current_zone(): ?array
{
    if (! class_exists('WC_Shipping_Zones')) return null;

    $packages = WC()->cart ? WC()->cart->get_shipping_packages() : [];
    $package  = $packages[0] ?? [
        'destination' => [
            'country'  => WC()->customer->get_shipping_country(),
            'state'    => WC()->customer->get_shipping_state(),
            'postcode' => WC()->customer->get_shipping_postcode(),
            'city'     => WC()->customer->get_shipping_city(),
            'address'  => WC()->customer->get_shipping_address(),
            'address_2' => WC()->customer->get_shipping_address_2(),
        ],
    ];

    $zone = WC_Shipping_Zones::get_zone_matching_package($package);

    if (! $zone) return null;

    foreach ($zone->get_shipping_methods(true) as $method) {
        if ('free_shipping' === $method->id && 'yes' === $method->enabled) {
            $requires         = $method->get_option('requires', 'no');
            $min_amount       = (float) $method->get_option('min_amount', 0);
            $ignore_discounts = 'yes' === $method->get_option('ignore_discounts', 'no');

            if (in_array($requires, ['min_amount', 'either', 'both'], true) && $min_amount > 0) {
                return [
                    'min_amount'        => $min_amount,
                    'ignore_discounts'  => $ignore_discounts,
                ];
            }
        }
    }

    return null;
}

function t888_get_cart_amount_for_free_shipping_check(bool $ignore_discounts): float
{
    if (! WC()->cart) return 0.0;

    if ($ignore_discounts) {
        $amount = WC()->cart->get_subtotal();
        if (wc_prices_include_tax()) {
            $amount += (float) WC()->cart->get_cart_contents_tax();
        }
        return (float) $amount;
    }

    return (float) WC()->cart->get_displayed_subtotal();
}







function t888f_sanitize_js( $input ) {
    if (!is_string($input)) return '';
    $input = wp_unslash($input);          
    $input = str_replace('<?', '', $input); 
    return trim($input);                  
}
add_action('wp_footer', function () {
    $custom_js = trim(get_theme_mod('custom_script', ''));

    if (!empty($custom_js)) {
        echo "<script id='theme-custom-js' type='text/javascript'>\n";
        echo "(function(){\n";
        echo "window.addEventListener('load', function() {\n";
        echo "{$custom_js}\n";
        echo "});\n";
        echo "})();\n";
        echo "</script>\n";
    }
}, 999);

add_filter('upload_mimes', function ($m) {
    $m['woff']  = 'font/woff';
    $m['woff2'] = 'font/woff2';
    $m['ttf']   = 'font/ttf';
    $m['otf']   = 'font/otf'; 
    return $m;
});


add_filter('wp_check_filetype_and_ext', function ($data, $file, $filename, $mimes) {
    $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    $allowed = [
        'woff'  => 'font/woff',
        'woff2' => 'font/woff2',
        'ttf'   => 'font/ttf',
        'otf'   => 'font/otf',
    ];
    if (isset($allowed[$ext])) {
        return [
            'ext'             => $ext,
            'type'            => $allowed[$ext],
            'proper_filename' => $data['proper_filename'],
        ];
    }
    return $data;
}, 10, 4);


