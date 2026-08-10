<?php
if (empty($tabs)) return;

$filter_mode = $filter_mode ?? 'categories';
$selected_categories = $product_categories ?? ['all'];
$selected_products = $selected_products ?? [];
$product_limit = $product_limit ?? 6;
?>

<div class="t888-product-tabs-wrapper style1">
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
                $product_query = t888_get_products_by_type($tab['product_filter'], $tax_query, $product_limit);
            }
            ?>
            <div class="t888-tab-panel t888-tab-<?php echo esc_attr($index); ?>" style="<?php echo esc_attr( $index === 0 ? '' : 'display:none' ); ?>">
                <?php if ($product_query->have_posts()): ?>
                    <div class="products-slider">
                        <div class="swiper-container eltech888-swiper-slider swiper-tab-<?php echo esc_attr($index); ?>"
                            data-items="4"
                            data-space="0"
                            data-loop="false"
                            data-navigation="true"
                            data-pagination="bullets"
                            data-speed="5000"
                            data-autoplay="no"
                            data-effect="slide"
                            data-items-widescreen="5"
                            data-items-laptop="4"
                            data-items-tablet-extra="3"
                            data-items-tablet="3"
                            data-items-mobile-extra="2"
                            data-items-mobile="2"
                            data-space-widescreen="40"
                            data-space-laptop="30"
                            data-space-tablet-extra="16"
                            data-space-tablet="16"
                            data-space-mobile-extra="-16"
                            data-space-mobile="-16">
                            
                            <div class="swiper-wrapper products">
                                <?php while ($product_query->have_posts()): $product_query->the_post(); ?>
                                    <?php
                                    $product = wc_get_product(get_the_ID());
                                    if (!$product || !$product->is_visible()) continue;
                                    ?>
                                    <div class="swiper-slide product-item">
                                        <?php
                                        t888f_get_template('woocommerce/loop/grid/grid', '', [
                                            'product' => $product,
                                            'size' => 'product-grid-default',
                                            'style' => 'default'
                                        ], true);
                                        ?>
                                    </div>
                                <?php endwhile; ?>
                            </div>

                            <div class="swiper-pagination t888-pagination-line swiper-pagination-<?php echo esc_attr($index); ?>"></div>
                        </div>
                    </div>
                <?php else: ?>
                    <p><?php _e('No products found for this tab.', 'nebon'); ?></p>
                <?php endif; ?>
                <?php wp_reset_postdata(); ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>
