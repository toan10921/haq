<?php
if (empty($style4_tabs)) return;

$product_limit = $product_limit ?? 7;
?>

<div class="t888-product-tabs-wrapper style4">
    <div class="t888-product-tabs-header">
        <h2 class="t888-product-tabs-title"><?php echo esc_html($title); ?></h2>
        <ul class="t888-product-tabs-nav">
            <?php foreach ($style4_tabs as $index => $tab): ?>
                <li class="<?php echo esc_attr( $index === 0 ? 'active' : '' ); ?>" data-tab="t888-tab-<?php echo esc_attr($index); ?>">
                    <?php echo esc_html($tab['tab_title']); ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <div class="t888-product-tabs-content">
        <?php foreach ($style4_tabs as $index => $tab): ?>
            <?php
            $infinitive_sale = isset($tab['infinitive_sale']) && $tab['infinitive_sale'] === 'yes';
            $special_id = (int) ($tab['tab_special_product'] ?? 0);
            $products_ids = array_filter(array_map('intval', $tab['tab_products'] ?? []));

            if ($special_id && in_array($special_id, $products_ids)) {
                $products_ids = array_diff($products_ids, [$special_id]);
            }

            $first_chunk = array_slice($products_ids, 0, 6);
            $remaining_chunks = array_chunk(array_slice($products_ids, 6), 8);
            ?>
            <div class="t888-tab-panel t888-tab-<?php echo esc_attr($index); ?>" style="<?php echo esc_attr( $index === 0 ? '' : 'display:none' ); ?>">
                <div class="swiper-container eltech888-swiper-slider swiper-tab-<?php echo esc_attr($index); ?>"
                     data-items="1"
                     data-space="30"
                     data-loop="false"
                     data-navigation="true"
                     data-pagination="false"
                     data-effect="slide">

                    <div class="swiper-wrapper">
                        <div class="swiper-slide t888-grid-countdown">
                            <div class="products grid shop-layout-4-cols gap-30">
                                <?php if ($special_id): ?>
                                    <?php $product = wc_get_product($special_id); ?>
                                    <?php if ($product && $product->is_visible()): ?>
                                        <?php
                                        $sale_start = (int) get_post_meta($special_id, '_sale_price_dates_from', true);
                                        $sale_end   = (int) get_post_meta($special_id, '_sale_price_dates_to', true);
                                        $now = time();

                                        if ($infinitive_sale && $sale_end < $now) {
                                            $sale_start = $now;
                                            $sale_end   = $now + (10 * DAY_IN_SECONDS);
                                        }
                                        ?>
                                        <div class="product-item grid-item--large">
                                            <?php
                                            t888f_get_template('woocommerce/loop/grid/grid-countdown', '', [
                                                'product'         => $product,
                                                'size'            => 'product-grid-default',
                                                'style'           => 'default',
                                                'sale_from'       => $sale_start,
                                                'sale_to'         => $sale_end,
                                                'infinitive_sale' => $infinitive_sale,
                                            ], true);
                                            ?>
                                        </div>
                                    <?php endif; ?>
                                <?php endif; ?>

                                <?php
                                $args = [
                                    'post_type' => 'product',
                                    'post_status' => 'publish',
                                    'post__in' => $first_chunk,
                                    'orderby' => 'post__in',
                                    'posts_per_page' => count($first_chunk),
                                ];
                                $query = new WP_Query($args);
                                while ($query->have_posts()): $query->the_post();
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
                                <?php endwhile;
                                wp_reset_postdata(); ?>
                            </div>
                        </div>

                        <?php foreach ($remaining_chunks as $chunk): ?>
                            <div class="swiper-slide t888-grid-countdown">
                                <div class="products grid shop-layout-4-cols gap-30">
                                    <?php
                                    $args = [
                                        'post_type' => 'product',
                                        'post_status' => 'publish',
                                        'post__in' => $chunk,
                                        'orderby' => 'post__in',
                                        'posts_per_page' => count($chunk),
                                    ];
                                    $query = new WP_Query($args);
                                    while ($query->have_posts()): $query->the_post();
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
                                    <?php endwhile;
                                    wp_reset_postdata(); ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="swiper-button-prev"><i class="las la-angle-left"></i></div>
                    <div class="swiper-button-next"><i class="las la-angle-right"></i></div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
