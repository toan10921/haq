<?php
$manual_tabs = is_array($tabs ?? null) ? $tabs : [];
$use_preset_tabs = ($style6_use_preset_tabs ?? 'yes') === 'yes';
$show_tab_arrows = ($style6_show_tab_arrows ?? 'yes') === 'yes';
$enable_time_filter = ($style6_enable_time_filter ?? 'no') === 'yes';
$time_filter_label_week = $style6_time_filter_label_week ?? __('The Week', 'nebon');
$time_filter_label_month = $style6_time_filter_label_month ?? __('The Month', 'nebon');
$time_filter_label_year = $style6_time_filter_label_year ?? __('The Year', 'nebon');
$grid_columns = (int) ($style6_grid_columns ?? 4);
$grid_rows = (int) ($style6_grid_rows ?? 1);
$enable_center_product = ($style6_enable_center_product ?? 'no') === 'yes' ? true : false;
$product_card_style = $style6_product_style ?? 'pet-category';

$tab_layout_style = $tab_layout_style ?? 'horizontal';
$vertical_nav_title = $vertical_nav_title ?? '';
$layout_class = ($tab_layout_style === 'vertical') ? ' vertical-layout' : '';

$enable_ad_box = ($style6_enable_ad_box ?? 'no') === 'yes';
$ad_items = is_array($style6_ad_items ?? null) ? $style6_ad_items : [];


if ($enable_center_product) {
    $grid_columns = 5;
    $grid_rows = 2;
    $product_limit = ($grid_columns * $grid_rows) - 1;  // 5×2 - 1 = 9
} else {
    $product_limit = $grid_columns * $grid_rows;
}

$show_badge_sale = ($style6_show_badge_sale ?? 'no') === 'yes' ? 'yes' : 'no';
$show_badge_new = ($style6_show_badge_new ?? 'no') === 'yes' ? 'yes' : 'no';
$show_badge_hot = ($style6_show_badge_hot ?? 'no') === 'yes' ? 'yes' : 'no';
$background_color = $style6_background_color ?? '#ffffff';

$render_product_card = function ($product) use ($product_card_style, $show_badge_sale, $show_badge_new, $show_badge_hot) {
    if ($product_card_style === 'standard') {
        t888f_get_template('woocommerce/loop/grid/grid-pet-category-horizontal', '', [
            'product' => $product,
            'show_badge_sale' => $show_badge_sale,
            'show_badge_new' => $show_badge_new,
            'show_badge_hot' => $show_badge_hot,
        ], true);
    } else {
        // Style 1: layout dọc mặc định
        t888f_get_template('woocommerce/loop/grid/grid-pet-category', '', [
            'product' => $product,
            'show_badge_sale' => $show_badge_sale,
            'show_badge_new' => $show_badge_new,
            'show_badge_hot' => $show_badge_hot,
        ], true);
    }
};



$tabs_resolved = $manual_tabs;
if ($use_preset_tabs) {
    $tabs_resolved = [
        [
            'tab_title_normal' => $style6_tab_label_featured ?? __('Featured', 'nebon'),
            'product_filter' => 'featured',
            'tab_filter_mode' => 'categories',
            'tab_categories' => [],
            'tab_products' => [],
        ],
        [
            'tab_title_normal' => $style6_tab_label_bestsellers ?? __('Best Sellers', 'nebon'),
            'product_filter' => 'bestsellers',
            'tab_filter_mode' => 'categories',
            'tab_categories' => [],
            'tab_products' => [],
        ],
        [
            'tab_title_normal' => $style6_tab_label_new_arrival ?? __('New Arrival', 'nebon'),
            'product_filter' => 'new',
            'tab_filter_mode' => 'categories',
            'tab_categories' => [],
            'tab_products' => [],
        ],
    ];
}

if (empty($tabs_resolved)) {
    return;
}

$tab_group_id = 't888-tabs-' . wp_rand(1000, 99999);
?>

<div class="t888-product-tabs-wrapper style6 <?php echo esc_attr($layout_class); ?>"
    style="background-color: <?php echo esc_attr($background_color); ?>;"
    data-tab-group="<?php echo esc_attr($tab_group_id); ?>">
    <div class="t888-style6-head<?php echo $enable_time_filter ? ' has-time-filter' : ''; ?>">
        <?php if ($tab_layout_style === 'vertical' && !empty($vertical_nav_title)): ?>
            <div class="t888-vertical-nav-title"><?php echo esc_html($vertical_nav_title); ?></div>
        <?php endif; ?>
        <ul class="t888-product-tabs-nav">
            <?php foreach ($tabs_resolved as $index => $tab): ?>
                <li class="<?php echo esc_attr($index === 0 ? 'active' : ''); ?>"
                    data-tab="t888-tab-<?php echo esc_attr($tab_group_id . '-' . $index); ?>">
                    <?php echo esc_html($tab['tab_title_normal'] ?? ''); ?>
                </li>
            <?php endforeach; ?>
        </ul>


        <div class="t888-style6-head-right">
            <?php if ($enable_time_filter): ?>
                <div class="t888-style6-time-filter" data-tab-group="<?php echo esc_attr($tab_group_id); ?>">
                    <button type="button" class="t888-time-filter-btn active" data-period="week">
                        <?php echo esc_html($time_filter_label_week); ?>
                    </button>
                    <button type="button" class="t888-time-filter-btn" data-period="month">
                        <?php echo esc_html($time_filter_label_month); ?>
                    </button>
                    <button type="button" class="t888-time-filter-btn" data-period="year">
                        <?php echo esc_html($time_filter_label_year); ?>
                    </button>
                </div>
            <?php endif; ?>

            <?php if ($show_tab_arrows): ?>
                <div class="t888-style6-tab-arrows">
                    <button type="button" class="t888-style6-tab-arrow style6-prev"
                        aria-label="<?php echo esc_attr__('Previous tab', 'nebon'); ?>">
                        <i class="las la-angle-left"></i>
                    </button>
                    <button type="button" class="t888-style6-tab-arrow style6-next"
                        aria-label="<?php echo esc_attr__('Next tab', 'nebon'); ?>">
                        <i class="las la-angle-right"></i>
                    </button>
                </div>
            <?php endif; ?>
        </div>
    </div>


    <?php if ($tab_layout_style === 'vertical' && $enable_ad_box && !empty($ad_items)): ?>
        <div class="t888-vertical-ad-box">
            <?php foreach ($ad_items as $ad_item): ?>
                <div class="t888-ad-item elementor-repeater-item-<?php echo esc_attr($ad_item['_id']); ?>">
                    <?php if ($ad_item['item_type'] === 'text'): ?>
                        <div class="ad-text-el">
                            <?php echo wp_kses_post($ad_item['text_content']); ?>
                        </div>
                    <?php elseif ($ad_item['item_type'] === 'image' && !empty($ad_item['image']['url'])):
                        $has_link = !empty($ad_item['link']['url']);
                        if ($has_link) {
                            $target = !empty($ad_item['link']['is_external']) ? ' target="_blank"' : '';
                            $rel = !empty($ad_item['link']['nofollow']) ? ' rel="nofollow"' : '';
                            echo '<a href="' . esc_url($ad_item['link']['url']) . '" class="ad-img-el" ' . $target . $rel . ' style="display:block;">';
                        } else {
                            echo '<div class="ad-img-el">';
                        }
                        ?>
                        <img src="<?php echo esc_url($ad_item['image']['url']); ?>" alt="Ad Image"
                            style="max-width: 100%; display: block;">
                        <?php
                        if ($has_link) {
                            echo '</a>';
                        } else {
                            echo '</div>';
                        }
                        ?>
                    <?php elseif ($ad_item['item_type'] === 'button'):
                        $target = !empty($ad_item['link']['is_external']) ? ' target="_blank"' : '';
                        $rel = !empty($ad_item['link']['nofollow']) ? ' rel="nofollow"' : '';
                        $href = !empty($ad_item['link']['url']) ? esc_url($ad_item['link']['url']) : '#';
                        ?>
                        <a href="<?php echo $href; ?>" class="ad-btn" <?php echo $target . $rel; ?>>
                            <?php echo esc_html($ad_item['button_text']); ?>
                        </a>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <div class="t888-product-tabs-content">
        <?php foreach ($tabs_resolved as $index => $tab): ?>
            <?php
            $filter_mode = $tab['tab_filter_mode'] ?? 'categories';
            $selected_categories = $tab['tab_categories'] ?? [];
            $selected_products = $tab['tab_products'] ?? [];
            $paged = 1;

            // Keep only valid term IDs and ignore legacy sentinels such as "all".
            if ($filter_mode === 'categories') {
                $selected_categories = array_values(array_filter(array_map('intval', (array) $selected_categories)));
            }

            $filter_ids = $filter_mode === 'products' ? $selected_products : $selected_categories;
            $filter_by = $filter_mode === 'products' ? 'product' : 'category';

            if ($enable_time_filter) {
                $tab_product_filter = $tab['product_filter'] ?? 'new';
                $product_query_week = t888_get_products_by_type($tab_product_filter, $filter_ids, $product_limit, $paged, $filter_by, '1 week ago');
                $product_query_month = t888_get_products_by_type($tab_product_filter, $filter_ids, $product_limit, $paged, $filter_by, '1 month ago');
                $product_query_year = t888_get_products_by_type($tab_product_filter, $filter_ids, $product_limit, $paged, $filter_by, '1 year ago');
                $product_query = $product_query_week;
            } else {
                $product_query = t888_get_products_by_type(
                    $tab['product_filter'] ?? 'new',
                    $filter_ids,
                    $product_limit,
                    $paged,
                    $filter_by
                );
            }
            ?>
            <div class="t888-tab-panel t888-tab-<?php echo esc_attr($tab_group_id . '-' . $index); ?>"
                style="<?php echo esc_attr($index === 0 ? '' : 'display:none'); ?>">

                <?php if ($enable_time_filter):
                    // Render 3 grids cho mỗi period, JS sẽ ẩn/hiện
                    $time_periods = [
                        'week' => $product_query_week,
                        'month' => $product_query_month,
                        'year' => $product_query_year,
                    ];
                    foreach ($time_periods as $period => $pq):
                        ?>
                        <div class="t888-time-panel" data-period="<?php echo esc_attr($period); ?>"
                            style="<?php echo esc_attr($period === 'week' ? '' : 'display:none'); ?>">
                            <?php if ($pq->have_posts()): ?>
                                <div
                                    class="products grid shop-layout-<?php echo esc_attr($grid_columns); ?>-cols gap-0<?php echo $enable_center_product ? ' has-large-center' : ''; ?>">
                                    <?php
                                    $index_item = 0;
                                    while ($pq->have_posts()):
                                        $pq->the_post();
                                        $product = wc_get_product(get_the_ID());
                                        if (!$product || !$product->is_visible()) {
                                            continue;
                                        }
                                        $item_class = 'product-item';
                                        if ($enable_center_product && $index_item === 2) {
                                            $item_class .= ' large-center-item';
                                        }
                                        ?>
                                        <div class="<?php echo esc_attr($item_class); ?>">
                                            <?php $render_product_card($product); ?>
                                        </div>
                                        <?php
                                        $index_item++;
                                    endwhile;
                                    wp_reset_postdata();
                                    ?>
                                </div>
                            <?php else: ?>
                                <div class="t888-no-products">
                                    <div class="t888-no-products-icon">
                                        <i class="las la-box-open"></i>
                                    </div>
                                    <p class="t888-no-products-title"><?php _e('No products found', 'nebon'); ?></p>
                                    <p class="t888-no-products-desc">
                                        <?php _e('There are no products matching this filter yet.', 'nebon'); ?></p>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>

                <?php else: // Không có time filter – render bình thường ?>
                    <?php if ($product_query->have_posts()): ?>
                        <div
                            class="products grid shop-layout-<?php echo esc_attr($grid_columns); ?>-cols gap-0<?php echo $enable_center_product ? ' has-large-center' : ''; ?>">
                            <?php
                            $index_item = 0;
                            while ($product_query->have_posts()):
                                $product_query->the_post();
                                $product = wc_get_product(get_the_ID());
                                if (!$product || !$product->is_visible()) {
                                    continue;
                                }
                                $item_class = 'product-item';
                                if ($enable_center_product && $index_item === 2) {
                                    $item_class .= ' large-center-item';
                                }
                                ?>
                                <div class="<?php echo esc_attr($item_class); ?>">
                                    <?php $render_product_card($product); ?>
                                </div>
                                <?php
                                $index_item++;
                            endwhile;
                            wp_reset_postdata();
                            ?>
                        </div>
                    <?php else: ?>
                        <div class="t888-no-products">
                            <div class="t888-no-products-icon">
                                <i class="las la-box-open"></i>
                            </div>
                            <p class="t888-no-products-title"><?php _e('No products found', 'nebon'); ?></p>
                            <p class="t888-no-products-desc">
                                <?php _e('There are no products matching this filter yet.', 'nebon'); ?></p>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>