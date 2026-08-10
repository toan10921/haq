<?php

/**
 * Navigation Menu Widget Template - Style 4
 * Vertical category menu (Shop by category)
 */
$menu_id = $menu_id ?? '';
$menu_location = $menu_location ?? 'header-menu';
$style4_label = (isset($style4_label) && $style4_label !== '') ? (string) $style4_label : __('SHOP BY CATEGORY', 'nebon');
$style4_icon_class = isset($style4_icon_class) ? trim((string) $style4_icon_class) : 'las la-bars';
$style4_expand_trigger = isset($style4_expand_trigger) ? (string) $style4_expand_trigger : 'hover';
$style4_expand_trigger = in_array($style4_expand_trigger, ['hover', 'click'], true) ? $style4_expand_trigger : 'hover';
$style4_color_scheme = isset($style4_color_scheme) ? (string) $style4_color_scheme : 'default';
$style4_color_scheme = in_array($style4_color_scheme, ['default', 'yellow-black'], true) ? $style4_color_scheme : 'default';
$style4_extra_content_style = isset($style4_extra_content_style) ? (string) $style4_extra_content_style : 'none';
$style4_extra_content_style = in_array($style4_extra_content_style, ['none', 'banner-h3', 'text-h2'], true) ? $style4_extra_content_style : 'none';
$style4_banner_eyebrow = isset($style4_banner_eyebrow) ? (string) $style4_banner_eyebrow : __('STARTS NOW', 'nebon');
$style4_banner_percent = isset($style4_banner_percent) ? (string) $style4_banner_percent : '50%';
$style4_banner_title = isset($style4_banner_title) ? (string) $style4_banner_title : __('HOLIDAY SALE', 'nebon');
$style4_banner_link_text = isset($style4_banner_link_text) ? (string) $style4_banner_link_text : __('SHOP NOW', 'nebon');
$style4_banner_link = (isset($style4_banner_link) && is_array($style4_banner_link)) ? $style4_banner_link : [];
$style4_banner_link_url = !empty($style4_banner_link['url']) ? $style4_banner_link['url'] : '';
$style4_banner_link_target = !empty($style4_banner_link['is_external']) ? ' target="_blank"' : '';
$style4_banner_link_rel = !empty($style4_banner_link['nofollow']) ? ' rel="nofollow"' : '';
$style4_banner_background = (isset($style4_banner_background) && is_array($style4_banner_background)) ? $style4_banner_background : [];
$style4_banner_background_url = !empty($style4_banner_background['url']) ? $style4_banner_background['url'] : '';
$style4_text_links = (isset($style4_text_links) && is_array($style4_text_links)) ? $style4_text_links : [];

$is_elementor_editor = false;
if (class_exists('\Elementor\Plugin')) {
    $is_elementor_editor = \Elementor\Plugin::$instance->editor->is_edit_mode();
}
$current_object = get_queried_object();
$current_slug = '';
$page_template_slug = '';

if ($current_object instanceof \WP_Post) {
    $current_slug = isset($current_object->post_name) ? (string) $current_object->post_name : '';
    $page_template_slug = (string) get_page_template_slug($current_object->ID);
}

$is_home_like_page = false;
if ($current_slug !== '' && preg_match('/^home([_-].+)?$/i', $current_slug)) {
    $is_home_like_page = true;
}

if (!$is_home_like_page && $page_template_slug !== '' && stripos($page_template_slug, 'home') !== false) {
    $is_home_like_page = true;
}

$is_home_expanded = is_front_page() || is_home() || $is_home_like_page || $is_elementor_editor;
?>
<div
    class="t888-vertical-menu t888-vertical-menu--style4 t888-vertical-menu--scheme-<?php echo esc_attr($style4_color_scheme); ?><?php echo $style4_extra_content_style !== 'none' ? ' has-extra-content extra-style-' . esc_attr($style4_extra_content_style) : ''; ?><?php echo $is_home_expanded ? ' is-home-expanded is-open' : ''; ?><?php echo !$is_home_expanded ? ' is-trigger-' . esc_attr($style4_expand_trigger) : ''; ?>"
    data-expand-trigger="<?php echo esc_attr($style4_expand_trigger); ?>"
    data-home-expanded="<?php echo esc_attr($is_home_expanded ? 'yes' : 'no'); ?>"
>
    <button class="t888-vertical-menu__header" type="button" aria-expanded="<?php echo esc_attr($is_home_expanded ? 'true' : 'false'); ?>">
        <?php if ($style4_icon_class !== '') : ?>
            <i class="<?php echo esc_attr($style4_icon_class); ?>" aria-hidden="true"></i>
        <?php endif; ?>
        <span><?php echo esc_html($style4_label); ?></span>
    </button>

    <div class="t888-vertical-menu__body" aria-hidden="<?php echo esc_attr($is_home_expanded ? 'false' : 'true'); ?>">
        <?php
        $menu_args = [
            'menu_class' => 't888-vertical-menu__list',
            'container' => false,
            'walker' => new \T888Core\t888f_Walker_Nav_Menu_Frontend(),
        ];

        if (!empty($menu_location) && has_nav_menu($menu_location)) {
            $menu_args['theme_location'] = $menu_location;
        } elseif (!empty($menu_id)) {
            $menu_args['menu'] = (int) $menu_id;
        }
        // var_dump($menu_args);

        wp_nav_menu($menu_args);

        if ($style4_extra_content_style === 'banner-h3') :
            $extra_style_attr = $style4_banner_background_url !== '' ? ' style="background-image:url(' . esc_url($style4_banner_background_url) . ');"' : '';
        ?>
            <div class="t888-vertical-menu__extra t888-vertical-menu__extra--banner-h3"<?php echo apply_filters('tech888f_output_content', $extra_style_attr); ?>>
                <div class="t888-vertical-menu__promo-card">
                    <?php if ($style4_banner_eyebrow !== '') : ?>
                        <span class="t888-vertical-menu__promo-eyebrow"><?php echo esc_html($style4_banner_eyebrow); ?></span>
                    <?php endif; ?>
                    <?php if ($style4_banner_percent !== '') : ?>
                        <h3 class="t888-vertical-menu__promo-percent"><?php echo esc_html($style4_banner_percent); ?></h3>
                    <?php endif; ?>
                    <?php if ($style4_banner_title !== '') : ?>
                        <p class="t888-vertical-menu__promo-title"><?php echo esc_html($style4_banner_title); ?></p>
                    <?php endif; ?>
                    <?php if ($style4_banner_link_text !== '') : ?>
                        <a class="t888-vertical-menu__promo-button" href="<?php echo esc_url($style4_banner_link_url ?: '#'); ?>"<?php echo apply_filters('tech888f_output_content', $style4_banner_link_target . $style4_banner_link_rel); ?>>
                            <?php echo esc_html($style4_banner_link_text); ?>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        <?php elseif ($style4_extra_content_style === 'text-h2' && !empty($style4_text_links)) : ?>
            <div class="t888-vertical-menu__extra t888-vertical-menu__extra--text-h2">
                <ul class="t888-vertical-menu__text-links">
                    <?php foreach ($style4_text_links as $item) :
                        $item_text = isset($item['text']) ? (string) $item['text'] : '';
                        $item_link = (isset($item['link']) && is_array($item['link'])) ? $item['link'] : [];
                        $item_url = !empty($item_link['url']) ? $item_link['url'] : '';
                        $item_target = !empty($item_link['is_external']) ? ' target="_blank"' : '';
                        $item_rel = !empty($item_link['nofollow']) ? ' rel="nofollow"' : '';

                        if ($item_text === '') {
                            continue;
                        }
                    ?>
                        <li class="t888-vertical-menu__text-link-item">
                            <a href="<?php echo esc_url($item_url ?: '#'); ?>"<?php echo apply_filters('tech888f_output_content', $item_target . $item_rel); ?>>
                                <h2><?php echo esc_html($item_text); ?></h2>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
    </div>
</div>
