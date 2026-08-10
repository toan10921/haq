<?php
$menu_title = $menu_title ?? __('Food', 'nebon');
$bird_image_url = $bird_image['url'] ?? '';
$menu_items = is_array($menu_items ?? null) ? $menu_items : [];

$banner_eyebrow = $banner_eyebrow ?? __('STARTS NOW', 'nebon');
$banner_discount_style = $banner_discount_style ?? 'text';
$banner_discount_value = $banner_discount_value ?? __('50', 'nebon');
$banner_discount_unit = $banner_discount_unit ?? __('%', 'nebon');
$banner_discount_unit_image_url = $banner_discount_unit_image['url'] ?? '';
$banner_discount_label = $banner_discount_label ?? __('OFF', 'nebon');
$banner_discount_image_url = $banner_discount_image['url'] ?? '';
$banner_title = $banner_title ?? __('HOLIDAY SALE', 'nebon');
$banner_button_text = $banner_button_text ?? __('SHOP NOW', 'nebon');
$banner_button_link_url = $banner_button_link['url'] ?? '#';
$banner_button_target = !empty($banner_button_link['is_external']) ? ' target="_blank"' : '';
$banner_button_nofollow = !empty($banner_button_link['nofollow']) ? ' rel="nofollow"' : '';
$banner_background = $banner_background ?? '#efe4b5';
$banner_overlay_image_url = $banner_overlay_image['url'] ?? '';
$banner_text_color = $banner_text_color ?? '#111111';
$button_background = $button_background ?? '#ffffff';
$button_text_color = $button_text_color ?? '#111111';
?>

<div
    class="bird-mega-menu-home2<?php echo empty($bird_image_url) ? ' bird-mega-menu-home2--no-art' : ''; ?>"
    style="
        --bird-menu-banner-bg: <?php echo esc_attr($banner_background); ?>;
        --bird-menu-banner-text: <?php echo esc_attr($banner_text_color); ?>;
        --bird-menu-button-bg: <?php echo esc_attr($button_background); ?>;
        --bird-menu-button-text: <?php echo esc_attr($button_text_color); ?>;
    ">
    <div class="bird-mega-menu-home2__grid">
        <?php if (!empty($bird_image_url)): ?>
            <div class="bird-mega-menu-home2__art">
                <img class="bird-mega-menu-home2__bird-image" src="<?php echo esc_url($bird_image_url); ?>" alt="<?php esc_attr_e('Bird illustration', 'nebon'); ?>">
            </div>
        <?php endif; ?>

        <div class="bird-mega-menu-home2__links">
            <?php if (!empty($menu_title)): ?>
                <h4 class="bird-mega-menu-home2__title"><?php echo esc_html($menu_title); ?></h4>
            <?php endif; ?>

            <?php if (!empty($menu_items)): ?>
                <ul class="bird-mega-menu-home2__list">
                    <?php foreach ($menu_items as $item):
                        $item_text = $item['text'] ?? '';
                        $item_url = $item['link']['url'] ?? '#';
                        $item_target = !empty($item['link']['is_external']) ? ' target="_blank"' : '';
                        $item_nofollow = !empty($item['link']['nofollow']) ? ' rel="nofollow"' : '';

                        if (empty($item_text)) {
                            continue;
                        }
                    ?>
                        <li>
                            <a href="<?php echo esc_url($item_url); ?>" <?php echo $item_target . $item_nofollow; ?>>
                                <?php echo esc_html($item_text); ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>

        <div class="bird-mega-menu-home2__banner">
            <?php if (!empty($banner_overlay_image_url)): ?>
                <div class="bird-mega-menu-home2__banner-overlay" aria-hidden="true">
                    <img src="<?php echo esc_url($banner_overlay_image_url); ?>" alt="">
                </div>
            <?php endif; ?>

            <div class="bird-mega-menu-home2__banner-content">
                <?php if (!empty($banner_eyebrow)): ?>
                    <p class="bird-mega-menu-home2__eyebrow"><?php echo esc_html($banner_eyebrow); ?></p>
                <?php endif; ?>

                <?php if ('image' === $banner_discount_style && !empty($banner_discount_image_url)): ?>
                    <div class="bird-mega-menu-home2__discount bird-mega-menu-home2__discount--image">
                        <img src="<?php echo esc_url($banner_discount_image_url); ?>" alt="<?php echo esc_attr($banner_title); ?>">
                    </div>
                <?php elseif (!empty($banner_discount_value) || !empty($banner_discount_label)): ?>
                    <div class="bird-mega-menu-home2__discount bird-mega-menu-home2__discount--text">

                        <div class="bird-mega-menu-home2__discount-main">
                            <?php if (!empty($banner_discount_value)): ?>
                                <span class="bird-mega-menu-home2__discount-value">
                                    <?php echo esc_html($banner_discount_value); ?>
                                </span>
                            <?php endif; ?>

                            <?php if (!empty($banner_discount_unit_image_url)): ?>
                                <span
                                    class="bird-mega-menu-home2__discount-unit bird-mega-menu-home2__discount-unit--image"
                                    style="--bird-menu-discount-unit-image: url('<?php echo esc_url($banner_discount_unit_image_url); ?>');"
                                >
                                    <img src="<?php echo esc_url($banner_discount_unit_image_url); ?>" alt="<?php echo esc_attr($banner_discount_unit); ?>">
                                </span>
                            <?php elseif (!empty($banner_discount_unit)): ?>
                                <span class="bird-mega-menu-home2__discount-unit">
                                    <?php echo esc_html($banner_discount_unit); ?>
                                </span>
                            <?php endif; ?>
                        </div>

                        <?php if (!empty($banner_discount_label)): ?>
                            <span class="bird-mega-menu-home2__discount-label">
                                <?php echo esc_html($banner_discount_label); ?>
                            </span>
                        <?php endif; ?>

                    </div>
                <?php endif; ?>

                <?php if (!empty($banner_title)): ?>
                    <p class="bird-mega-menu-home2__banner-title"><?php echo esc_html($banner_title); ?></p>
                <?php endif; ?>

                <?php if (!empty($banner_button_text)): ?>
                    <a class="bird-mega-menu-home2__button" href="<?php echo esc_url($banner_button_link_url); ?>" <?php echo $banner_button_target . $banner_button_nofollow; ?>>
                        <?php echo esc_html($banner_button_text); ?>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
