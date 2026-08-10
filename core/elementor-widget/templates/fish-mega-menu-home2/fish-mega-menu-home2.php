<?php
$banner_heading = $banner_heading ?? __('Shop everything for fish', 'nebon');
$banner_discount = $banner_discount ?? __('50% Off', 'nebon');
$banner_button_text = $banner_button_text ?? __('SHOP NOW', 'nebon');
$banner_button_link_url = $banner_button_link['url'] ?? '#';
$banner_button_target = !empty($banner_button_link['is_external']) ? ' target="_blank"' : '';
$banner_button_nofollow = !empty($banner_button_link['nofollow']) ? ' rel="nofollow"' : '';
$banner_background = $banner_background ?? '#b96a3f';
$banner_background_image_url = $banner_background_image['url'] ?? '';
$banner_text_color = $banner_text_color ?? '#ffffff';
$button_background = $button_background ?? '#ffffff';
$button_text_color = $button_text_color ?? '#111111';
$fish_image_url = $fish_image['url'] ?? '';
$shop_title = $shop_title ?? __('Fish shop', 'nebon');
$column_1_items = is_array($column_1_items ?? null) ? $column_1_items : [];
$column_2_items = is_array($column_2_items ?? null) ? $column_2_items : [];
$column_3_items = is_array($column_3_items ?? null) ? $column_3_items : [];

$fish_menu_columns = [
    $column_1_items,
    $column_2_items,
    $column_3_items,
];
?>

<div
    class="fish-mega-menu-home2"
    style="
        --fish-menu-banner-bg: <?php echo esc_attr($banner_background); ?>; 
        --fish-menu-banner-image: url('<?php echo esc_url($banner_background_image_url); ?>');
        --fish-menu-text: <?php echo esc_attr($banner_text_color); ?>;
        --fish-menu-button-bg: <?php echo esc_attr($button_background); ?>;
        --fish-menu-button-text: <?php echo esc_attr($button_text_color); ?>;
    "
>
    <div class="fish-mega-menu-home2__hero">
        <?php if (!empty($fish_image_url)): ?>
            <div class="fish-mega-menu-home2__art" aria-hidden="true">
                <img class="fish-mega-menu-home2__fish-image" src="<?php echo esc_url($fish_image_url); ?>" alt="<?php esc_attr_e('Fish illustration', 'nebon'); ?>">
            </div>
        <?php endif; ?>

        <div class="fish-mega-menu-home2__content">
            <?php if (!empty($banner_heading)): ?>
                <p class="fish-mega-menu-home2__heading"><?php echo esc_html($banner_heading); ?></p>
            <?php endif; ?>

            <?php if (!empty($banner_discount)): ?>
                <div class="fish-mega-menu-home2__discount"><?php echo esc_html($banner_discount); ?></div>
            <?php endif; ?>

            <?php if (!empty($banner_button_text)): ?>
                <a class="fish-mega-menu-home2__button" href="<?php echo esc_url($banner_button_link_url); ?>"<?php echo $banner_button_target . $banner_button_nofollow; ?>>
                    <?php echo esc_html($banner_button_text); ?>
                </a>
            <?php endif; ?>
        </div>
    </div>

    <div class="fish-mega-menu-home2__links">
        <?php if (!empty($shop_title)): ?>
            <h4 class="fish-mega-menu-home2__links-title"><?php echo esc_html($shop_title); ?></h4>
        <?php endif; ?>

        <div class="fish-mega-menu-home2__columns">
            <?php foreach ($fish_menu_columns as $items): ?>
                <ul class="fish-mega-menu-home2__list">
                    <?php foreach ($items as $item):
                        $item_text = $item['text'] ?? '';
                        $item_url = $item['link']['url'] ?? '#';
                        $item_target = !empty($item['link']['is_external']) ? ' target="_blank"' : '';
                        $item_nofollow = !empty($item['link']['nofollow']) ? ' rel="nofollow"' : '';

                        if (empty($item_text)) {
                            continue;
                        }
                    ?>
                        <li>
                            <a href="<?php echo esc_url($item_url); ?>"<?php echo $item_target . $item_nofollow; ?>>
                                <?php echo esc_html($item_text); ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endforeach; ?>
        </div>
    </div>
</div>
