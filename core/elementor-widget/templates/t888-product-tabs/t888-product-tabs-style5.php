<?php
if (empty($tabs)) return;

$filter_mode = $filter_mode ?? 'categories';
$selected_categories = $product_categories ?? ['all'];
$selected_products = $selected_products ?? [];
$product_limit = $product_limit ?? 6;
?>

<div class="t888-product-tabs-wrapper style5">
    <ul class="t888-product-tabs-nav">
        <?php foreach ($tabs as $index => $tab): ?>
            <li class="<?php echo esc_attr( $index === 0 ? 'active' : '' ); ?>" data-tab="t888-tab-<?php echo esc_attr($index); ?>">
                <?php echo esc_html($tab['tab_title_normal'] ?? ''); ?>
            </li>
            <?php if ($index < count($tabs) - 1): ?>
                <li class="tab-separator">/</li>
            <?php endif; ?>
        <?php endforeach; ?>
    </ul>

    <div class="t888-product-tabs-content">
        <?php foreach ($tabs as $index => $tab): ?>
            <?php
            if ($filter_mode === 'products' && !empty($selected_products)) {
                $args = [
                    'post_type' => 'product',
                    'post__in' => $selected_products,
                    'orderby' => 'post__in',
                    'posts_per_page' => $product_limit,
                ];
                $product_query = new WP_Query($args);
            } else {
                $tax_query = in_array('all', $selected_categories) ? [] : $selected_categories;
                $product_query = t888_get_products_by_type($tab['product_filter'] ?? 'new', $tax_query, $product_limit);
            }
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
                                    'size'    => 'product-grid-default',
                                    'style'   => 'default'
                                ], true);
                                ?>
                            </div>
                        <?php endwhile; ?>
                    </div>
                <?php else: ?>
                    <p><?php _e('No products found for this tab.', 'nebon'); ?></p>
                <?php endif; ?>
                <?php wp_reset_postdata(); ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>
