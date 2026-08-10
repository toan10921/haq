<?php

namespace T888Core;

/**
 * Class T888f_CustomMenu
 * 
 * This class handles the custom fields for the mega menu in the WordPress admin.
 */
class T888f_CustomMenu
{
    // use blog post trait for fulfilling function _tech888f_list_post_type
    use BlogPostTrait;
    /**
     * @var T888f_CustomMenu|null The single instance of the class.
     */
    private static $instance = null;

    /**
     * @var array The custom fields for the menu items.
     */
    static $allFields;

    /**
     * T888f_CustomMenu constructor.
     * 
     * Initializes the custom fields and hooks into WordPress actions and filters.
     */
    private function __construct()
    {
        self::$allFields = array(
            't888_menu_custom_label' => array(
                'label' => esc_html__('Custom Label (override menu title)', 'nebon'),
                'type' => 'text',
                'depth' => 0,
            ),
            't888_menu_icon_class' => array(
                'label' => esc_html__('Icon CSS Class (example: "las la-dog")', 'nebon'),
                'type' => 'text',
                'depth' => 0,
            ),
            'enable_megamenu' => array(
                'label' => esc_html__('Enable Mega menu', 'nebon'),
                'type' => 'checkbox',
                'depth' => 0,
            ),
            'custom_width' => array(
                'label' => esc_html__('Custom width Mega menu. Example "500px".', 'nebon'),
                'type' => 'text',
                'class' => 'hidden-field', // Add a class to hide by default
            ),
            'content' => array(
                'label' => esc_html__('Content From Mega Item', 'nebon'),
                'type' => 'select',
                'depth' => 0,
                'choices' => self::_tech888f_list_post_type('mega_item', false),
                'class' => 'hidden-field', // Add a class to hide by default
            ),
        );
        //add menu custom fields
        add_filter('wp_setup_nav_menu_item', array($this, 'add_custom_menu_fields'));
        //Add walker
        add_filter('wp_edit_nav_menu_walker', array($this, 'add_menu_custom_walker'), 10, 2);
        // save menu custom fields
        add_action('wp_update_nav_menu_item', array($this, 'save_custom_menu_fields'), 10, 3);
        // add script to admin handle custom field display depend on enable_megamenu checkbox
        add_action('admin_enqueue_scripts', array($this, 'enqueue_custom_admin_scripts'));
    }

    /**
     * Enqueue custom admin scripts.
     */
    public static function enqueue_custom_admin_scripts($hook_suffix)
    {
        if ($hook_suffix === 'nav-menus.php') {
            wp_enqueue_script('custom-field-walker-nav-menu', get_template_directory_uri() . '/assets/admin/js/custom-field-walker-nav-menu.js', array('jquery'), null, true);
        }
    }

    /**
     * Get the single instance of the class.
     * 
     * @return T888f_CustomMenu The single instance of the class.
     */
    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Add custom fields to the menu item.
     * 
     * @param object $item The menu item.
     * @return object The menu item with custom fields.
     */
    static function add_custom_menu_fields($item)
    {
        //
        if (!empty(self::$allFields)) {
            foreach (self::$allFields as $key => $value) {
                $item->$key = get_post_meta($item->ID, $key, TRUE);
            }
        }
        return $item;
    }

    /**
     * Save custom fields for the menu item.
     * 
     * @param int $menu_id The menu ID.
     * @param int $menu_item_db_id The menu item database ID.
     * @param array $args The menu item arguments.
     */
    static function save_custom_menu_fields($menu_id, $menu_item_db_id, $args)
    {
        if (!empty(self::$allFields)) {
            foreach (self::$allFields as $key => $value) {
                if (isset($_REQUEST[$key][$menu_item_db_id])) {
                    $data = $_REQUEST[$key][$menu_item_db_id];

                    // Basic sanitization by field type.
                    if ($value['type'] === 'text') {
                        $data = sanitize_text_field($data);
                    } elseif ($value['type'] === 'image') {
                        $data = absint($data);
                    }
                    update_post_meta($menu_item_db_id, $key, $data);
                } elseif (isset($args[$key])) {
                    $data = $args[$key];
                    update_post_meta($menu_item_db_id, $key, $data);
                }

                if ($value['type'] == 'checkbox') {
                    if (!isset($_REQUEST[$key][$menu_item_db_id])) {
                        delete_post_meta($menu_item_db_id, $key);
                    }
                }
            }
        }
    }

    /**
     * Add custom walker for the menu.
     * 
     * @return string The custom walker class name.
     */
    static function add_menu_custom_walker()
    {
        return  t888f_WalkerAdminNavMenu::class;
    }

    /**
     * Add custom fields to the admin menu item form.
     * 
     * @param object $item The menu item.
     * @param int $d The depth of the menu item.
     */
    static function AdminAddFields($item, $d = 0)
    {
        if (!empty(self::$allFields)) {
            foreach (self::$allFields as $key => $value) {
                $default = array(
                    'type'  => '',
                    'class' => "",
                    'compare' => '',
                    'min_depth' => '',
                    'depth' => ''
                );
                $value = wp_parse_args($value, $default);

                if ($value['min_depth'] and  $d < $value['min_depth']) {
                    continue;
                }

                if ($value['depth'] !== '' and  $d != $value['depth']) {
                    continue;
                }

                $func = '_field_type_' . $value['type'];
                if (method_exists(__CLASS__, $func)) {
                    self::$func($item, $key, $value, $d);
                }
            }
        }
    }

    // =======================================================================
    // Field helper
    /*
         *
         *
         * */

    /**
     * Render an image field.
     * 
     * @param object $item The menu item.
     * @param string $key The field key.
     * @param array $value The field value.
     * @param int $d The depth of the menu item.
     */
    static function _field_type_image($item, $key, $value, $d = 0)
    {
        $item_id = $item->ID;
        $item_value = get_post_meta($item_id, $key, true);
?>
        <p class="field-custom description description-wide">
            <label><?php echo esc_html($value['label']) ?></label>
        <div class="wrap-metabox">
            <div class="live-previews">
                <?php if (!empty($item_value)): ?>
                    <img src="<?php echo wp_get_attachment_url($item_value) ?>" />
                <?php endif; ?>
            </div>
            <a class="button button-primary t888f-button-remove"> <?php esc_html_e("Remove", "nebon") ?></a>
            <a class="button button-primary t888f-button-upload-id"><?php esc_html_e("Upload", "nebon") ?></a>
            <input id="<?php echo esc_attr($item_id . $key) ?>" name="<?php echo esc_attr($key . '[' . $item_id . ']'); ?>" type="hidden" class="widefat code edit-menu-item-custom t888f-image-value" value="<?php echo esc_attr($item_value) ?>"></input>
        </div>
        </p>
    <?php
    }

    /**
     * Render a text field.
     * 
     * @param object $item The menu item.
     * @param string $key The field key.
     * @param array $value The field value.
     * @param int $d The depth of the menu item.
     */
    static function _field_type_text($item, $key, $value, $d = 0)
    {
        $item_id = $item->ID;
        $item_value = get_post_meta($item_id, $key, true);
    ?>
        <p class="field-custom description description-wide">
            <label for="<?php echo esc_attr($item_id . $key) ?>">
                <?php echo esc_html($value['label']) ?>
                <input type="text" id="<?php echo esc_attr($item_id . $key) ?>" class="widefat code edit-menu-item-custom <?php echo isset($value['class']) ? $value['class'] : false ?>" value="<?php echo esc_attr($item_value) ?>" name="<?php echo esc_attr($key . '[' . $item_id . ']'); ?>" />

            </label>
        </p>
    <?php
    }

    /**
     * Render a text HTML field.
     * 
     * @param object $item The menu item.
     * @param string $key The field key.
     * @param array $value The field value.
     * @param int $d The depth of the menu item.
     */
    static function _field_type_text_html($item, $key, $value, $d = 0)
    {
        $item_id = $item->ID;
        $item_value = get_post_meta($item_id, $key, true);
        $name = $key . '[' . $item_id . ']';
        $wp_editor_settings = array(
            'wpautop' => false,
            'textarea_rows' => 5,
            'textarea_name' => $name,
        );
    ?>
        <div id="wp-content-wrap" class="wp-content">
            <label for="<?php echo esc_attr($item_id . $key) ?>">
                <?php echo esc_html($value['label']) ?>
            </label>
            <?php wp_editor($item_value, $item_id, $wp_editor_settings); ?>
        </div>
    <?php
    }

    /**
     * Render a checkbox field.
     * 
     * @param object $item The menu item.
     * @param string $key The field key.
     * @param array $value The field value.
     * @param int $d The depth of the menu item.
     */
    static function _field_type_checkbox($item, $key, $value, $d = 0)
    {
        $item_id = $item->ID;
        $default = array(
            'type'  => 'checkbox',
            'class' => "",
            'depth' => '',
            'label' => ''
        );
        $value = wp_parse_args($value, $default);

        if ($value['depth'] and $d > $value['depth']) return;
        $item_id = esc_attr($item->ID);
        $item_value = get_post_meta($item_id, 'enable_megamenu', true);
        if ($item_value) {
            update_post_meta($item_id, 'enable_megamenu', '1');
        }
    ?>
        <p class="field-custom description description-wide">
            <label for="<?php echo esc_attr($item_id . $key) ?>">
                <?php echo esc_html($value['label']);
                $en_check = ($value['type'] == 'checkbox' and ($item->$key == 1 || $item_value)) ? 'checked' : false ?>
                <input type="checkbox" id="<?php echo esc_attr($item_id . $key) ?>" class="widefat code edit-menu-item-custom <?php echo isset($value['class']) ? $value['class'] : false ?>" <?php echo esc_attr($en_check) ?> name="<?php echo esc_attr($key . '[' . $item_id . ']'); ?>" value="1" />

            </label>
        </p>
    <?php
    }

    /**
     * Render a select field.
     * 
     * @param object $item The menu item.
     * @param string $key The field key.
     * @param array $value The field value.
     * @param int $d The depth of the menu item.
     */
    static function _field_type_select($item, $key, $value, $d = 0)
    {

        $default = array(
            'type'  => 'select',
            'class' => "",
            'choices' => array()
        );

        $value = wp_parse_args($value, $default);

        $item_id = $item->ID;
    ?>
        <p class="field-custom description description-wide">
            <label for="<?php echo esc_attr($item_id . $key) ?>">
                <?php echo esc_html($value['label']) ?>

                <select class="widefat code edit-menu-item-custom <?php echo isset($value['class']) ? $value['class'] : false ?>" id="<?php echo esc_attr($item_id . $key) ?>" name="<?php echo esc_attr($key . '[' . $item_id . ']'); ?>">

                    <?php
                    if (!empty($value['choices'])) {
                        foreach ($value['choices'] as $k => $v) {

                            $select = selected($k, $item->$key, false);
                            echo "<option {$select} value='{$k}'>{$v}</option>";
                        }
                    }

                    ?>
                </select>

            </label>
        </p>
<?php
    }
}
/** fix text domain load before init */
add_action('init', [T888f_CustomMenu::class, 'getInstance']);
