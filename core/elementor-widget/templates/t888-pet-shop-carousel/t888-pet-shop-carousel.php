<?php
$title = $title ?? 'DOG SHOP';
$columns = $columns ?? '6';
$menu_items = is_array($menu_items ?? null) ? $menu_items : [];
$default_product_ids_raw = is_array($products ?? null) ? $products : [];
$default_product_ids = array_filter(array_map('intval', $default_product_ids_raw));
$show_badges = ($show_badges ?? '') === 'yes' ? 'yes' : '';
$autoplay = ($autoplay ?? '') === 'yes' ? 'yes' : '';
$autoplay_delay = max(1, (int)($autoplay_delay ?? 5));
$product_style = $product_style ?? 'style6';
$show_tab_arrows = ($style6_show_tab_arrows ?? 'yes') === 'yes';
$product_card_style = $style6_product_style ?? 'pet-category';
$show_badge_sale = isset($style6_show_badge_sale)
    ? (($style6_show_badge_sale ?? '') === 'yes' ? 'yes' : 'no')
    : $show_badges;
$show_badge_new = isset($style6_show_badge_new)
    ? (($style6_show_badge_new ?? '') === 'yes' ? 'yes' : 'no')
    : $show_badges;
$show_badge_hot = isset($style6_show_badge_hot)
    ? (($style6_show_badge_hot ?? '') === 'yes' ? 'yes' : 'no')
    : $show_badges;

if ($product_style === 'style6') {
    $product_template = $product_card_style === 'standard'
        ? 'woocommerce/loop/grid/grid-pet-category-horizontal'
        : 'woocommerce/loop/grid/grid-pet-category';
} else {
    $product_template = 'woocommerce/loop/grid/grid-pet-category';
}
$tabs = [];
$default_tab_id = 'default-products';

foreach ($menu_items as $index => $item) {
    $label = isset($item['label']) ? trim($item['label']) : '';
    $product_ids_raw = is_array($item['tab_products'] ?? null) ? $item['tab_products'] : [];
    $product_ids = array_filter(array_map('intval', $product_ids_raw));

    if ($label === '') {
        continue;
    }

    $tabs[] = [
        'id' => 'tab-' . ($item['_id'] ?? $index),
        'label' => $label,
        'product_ids' => !empty($product_ids) ? $product_ids : $default_product_ids,
    ];
}
?>

<div
    class="t888-pet-shop-carousel-module product-style-<?php echo esc_attr($product_style); ?>"
    data-autoplay="<?php echo esc_attr($autoplay); ?>"
    data-autoplay-delay="<?php echo esc_attr($autoplay_delay * 1000); ?>"
>
    <div class="pet-shop-carousel-header">
        <div class="header-left">
            <button
                class="pet-shop-carousel-title menu-item pet-shop-carousel-tab-trigger<?php echo !empty($default_product_ids) || empty($tabs) ? ' is-active' : ''; ?>"
                type="button"
                role="tab"
                aria-selected="<?php echo !empty($default_product_ids) || empty($tabs) ? 'true' : 'false'; ?>"
                data-tab-target="<?php echo esc_attr(!empty($default_product_ids) ? $default_tab_id : (!empty($tabs) ? $tabs[0]['id'] : '')); ?>"
            >
                <?php echo esc_html($title); ?>
            </button>

            <?php if (!empty($tabs)) : ?>
                <div class="pet-shop-carousel-menu" role="tablist" aria-label="<?php echo esc_attr__('Product tabs', 'nebon'); ?>">
                    <?php foreach ($tabs as $index => $tab) : ?>
                        <button
                            class="menu-item pet-shop-carousel-tab-trigger<?php echo $index === 0 && empty($default_product_ids) ? ' is-active' : ''; ?>"
                            type="button"
                            role="tab"
                            aria-selected="<?php echo $index === 0 && empty($default_product_ids) ? 'true' : 'false'; ?>"
                            data-tab-target="<?php echo esc_attr($tab['id']); ?>"
                        >
                            <?php echo esc_html($tab['label']); ?>
                        </button>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <?php if ($show_tab_arrows) : ?>
            <div class="header-nav">
                <button class="nav-prev" type="button" aria-label="<?php echo esc_attr__('Previous', 'nebon'); ?>"><i class="las la-angle-left"></i></button>
                <button class="nav-next" type="button" aria-label="<?php echo esc_attr__('Next', 'nebon'); ?>"><i class="las la-angle-right"></i></button>
            </div>
        <?php endif; ?>
    </div>

    <div class="pet-shop-carousel-tabs">
        <?php if (!empty($default_product_ids)) : ?>
            <div
                class="pet-shop-carousel-panel is-active"
                data-tab-panel="<?php echo esc_attr($default_tab_id); ?>"
                <?php echo !empty($default_product_ids) ? '' : ' hidden'; ?>
            >
                <div class="pet-shop-carousel-list swiper swiper-pet-shop-carousel" data-columns="<?php echo esc_attr($columns); ?>">
                    <div class="swiper-wrapper">
                        <?php foreach ($default_product_ids as $product_id) :
                            $product = wc_get_product($product_id);
                            if (!$product || !$product->is_visible()) {
                                continue;
                            }
                            ?>
                            <div class="swiper-slide product-item-wrap">
                                <?php
                                t888f_get_template($product_template, '', [
                                    'product' => $product,
                                    'size' => 'woocommerce_thumbnail',
                                    'style' => 'default',
                                    'show_badge_sale' => $show_badge_sale,
                                    'show_badge_new' => $show_badge_new,
                                    'show_badge_hot' => $show_badge_hot,
                                ], true);
                                ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <?php if (!empty($tabs)) : ?>
            <?php foreach ($tabs as $index => $tab) : ?>
                <div
                    class="pet-shop-carousel-panel<?php echo $index === 0 && empty($default_product_ids) ? ' is-active' : ''; ?>"
                    data-tab-panel="<?php echo esc_attr($tab['id']); ?>"
                    <?php echo $index === 0 && empty($default_product_ids) ? '' : ' hidden'; ?>
                >
                    <div class="pet-shop-carousel-list swiper swiper-pet-shop-carousel" data-columns="<?php echo esc_attr($columns); ?>">
                        <div class="swiper-wrapper">
                            <?php if (!empty($tab['product_ids'])) : ?>
                                <?php foreach ($tab['product_ids'] as $product_id) :
                                    $product = wc_get_product($product_id);
                                    if (!$product || !$product->is_visible()) {
                                        continue;
                                    }
                                    ?>
                                    <div class="swiper-slide product-item-wrap">
                                        <?php
                                        t888f_get_template($product_template, '', [
                                            'product' => $product,
                                            'size' => 'woocommerce_thumbnail',
                                            'style' => 'default',
                                            'show_badge_sale' => $show_badge_sale,
                                            'show_badge_new' => $show_badge_new,
                                            'show_badge_hot' => $show_badge_hot,
                                        ], true);
                                        ?>
                                    </div>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <p class="pet-shop-carousel-empty"><?php esc_html_e('Please select products for this tab.', 'nebon'); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <p class="pet-shop-carousel-empty"><?php esc_html_e('Please select products in the widget settings.', 'nebon'); ?></p>
        <?php endif; ?>
    </div>
</div>
