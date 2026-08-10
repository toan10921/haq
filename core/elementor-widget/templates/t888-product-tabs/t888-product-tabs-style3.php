<?php
if (empty($tabs)) return;

$product_limit = $product_limit ?? 6;
?>

<div class="t888-product-tabs-wrapper style3">
    <div class="t888-product-tabs-header">
        <h2 class="t888-product-tabs-title"><?php echo esc_html($title); ?></h2>
        <ul class="t888-product-tabs-nav">
            <?php foreach ($tabs as $index => $tab): ?>
                <li class="<?php echo esc_attr( $index === 0 ? 'active' : '' ); ?>" data-tab="t888-tab-<?php echo esc_attr($index); ?>">
                    <?php echo esc_html($tab['tab_title_normal']); ?>
                </li>

            <?php endforeach; ?>
        </ul>
    </div>

    <div class="t888-product-tabs-content">
        <?php foreach ($tabs as $index => $tab): ?>
            <?php
            $tab_query = null;
            $filter_mode = $tab['tab_filter_mode'] ?? 'categories';
            $product_filter = $tab['product_filter'] ?? 'new';

            if ($filter_mode === 'products' && !empty($tab['tab_products'])) {
                $args = [
                    'post_type' => 'product',
                    'post__in' => $tab['tab_products'],
                    'orderby' => 'post__in',
                    'posts_per_page' => $product_limit,
                ];
                $tab_query = new WP_Query($args);
            } else {
                $category_ids = !empty($tab['tab_categories']) ? $tab['tab_categories'] : [];
                $tab_query = t888_get_products_by_type($product_filter, $category_ids, $product_limit);
            }
            ?>
            <div class="t888-tab-panel t888-tab-<?php echo esc_attr($index); ?>" style="<?php echo esc_attr( $index === 0 ? '' : 'display:none' ); ?>">
                <?php if ($tab_query->have_posts()): ?>
                    <div class="products-slider">
                        <div class="swiper-container eltech888-swiper-slider swiper-tab-<?php echo esc_attr($index); ?>"
                            data-items="4"
                            data-space="30"
                            data-loop="false"
                            data-navigation="true"
                            data-speed="5000"
                            data-autoplay="yes"
                            data-effect="slide"
                            data-items-widescreen="5"
                            data-items-laptop="4"
                            data-items-tablet-extra="2"
                            data-items-tablet="2"
                            data-items-mobile-extra="2"
                            data-items-mobile="2"
                            data-space-widescreen="40"
                            data-space-laptop="30"
                    
                            data-space-mobile-extra="-16"
                            data-space-mobile="-16">

                            <div class="swiper-wrapper products">
                                <?php while ($tab_query->have_posts()): $tab_query->the_post(); ?>
                                    <?php
                                    $product = wc_get_product(get_the_ID());
                                    if (!$product || !$product->is_visible()) continue;
                                    ?>
                                    <div class="swiper-slide product-item">
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

                            <div class="swiper-button-prev"><i class="las la-angle-left"></i></div>
                            <div class="swiper-button-next"><i class="las la-angle-right"></i></div>
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