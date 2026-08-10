<?php
if (empty($tabs)) return;

$product_limit = $product_limit ?? 8;
$loadmore_enabled = true;
?>

<div class="t888-product-tabs-wrapper style2">
    <ul class="t888-product-tabs-nav">
        <?php foreach ($tabs as $index => $tab): ?>
            <li class="<?php echo esc_attr( $index === 0 ? 'active' : '' ); ?>" data-tab="t888-tab-<?php echo esc_attr($index); ?>">
                <?php echo esc_html($tab['tab_title_normal']); ?>
            </li>
            <?php if ($index < count($tabs) - 1): ?>
                <li class="tab-separator">/</li>
            <?php endif; ?>
        <?php endforeach; ?>
    </ul>

    <div class="t888-product-tabs-content">
        <?php foreach ($tabs as $index => $tab): ?>
            <?php
  
            $filter_mode = $tab['tab_filter_mode'] ?? 'categories';
            $selected_categories = $tab['tab_categories'] ?? ['all'];
            $selected_products = $tab['tab_products'] ?? [];
            $paged = 1;

            $filter_ids = $filter_mode === 'products' ? $selected_products : $selected_categories;
            $filter_by = $filter_mode === 'products' ? 'product' : 'category';

            $product_query = t888_get_products_by_type(
                $tab['product_filter'],
                $filter_ids,
                $product_limit,
                $paged,
                $filter_by
            );
            ?>
            <div class="t888-tab-panel t888-tab-<?php echo esc_attr($index); ?>" style="<?php echo esc_attr( $index === 0 ? '' : 'display:none' ); ?>">
                <?php if ($product_query->have_posts()): ?>
                    <div class="products grid shop-layout-4-cols gap-30">
                        <?php while ($product_query->have_posts()): $product_query->the_post(); ?>
                            <?php
                            $product = wc_get_product(get_the_ID());
                            if (!$product || !$product->is_visible()) continue;
                            ?>
                            <div class="product-item">
                                <?php
                                t888f_get_template('woocommerce/loop/grid/grid', '', [
                                    'product' => $product,
                                    'size' => 'product-grid-default',
                                    'style' => 'default'
                                    // 'size'    => get_theme_mod('show_single_size_extra_display', 'woocommerce_thumbnail'),
                                    // 'style'   => get_theme_mod('single_item_style_extra_display', 'default')
                                ], true);
                                ?>
                            </div>
                        <?php endwhile; ?>
                    </div>

                    <?php if ($loadmore_enabled && $product_query->max_num_pages > 1): ?>
                        <div class="t888-loadmore-wrap" data-tab="<?php echo esc_attr($index); ?>">
                            <button class="t888-loadmore-button button"
                                data-paged="1"
                                data-total="<?php echo esc_attr($product_query->max_num_pages); ?>"
                                data-filter-mode="<?php echo esc_attr($filter_mode); ?>"
                                data-product-filter="<?php echo esc_attr($tab['product_filter']); ?>"
                                data-product-ids='<?php echo json_encode($selected_products); ?>'
                                data-categories='<?php echo json_encode($selected_categories); ?>'
                                data-product-limit="<?php echo esc_attr($product_limit); ?>">
                                <?php _e('Load More', 'nebon'); ?>
                            </button>
                        </div>
                    <?php endif; ?>
                <?php else: ?>
                    <p><?php _e('No products found for this tab.', 'nebon'); ?></p>
                <?php endif; ?>
                <?php wp_reset_postdata(); ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>
