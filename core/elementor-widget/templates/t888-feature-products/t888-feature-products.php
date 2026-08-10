<?php
$main_title = $main_title ?? '';
$product_list = $product_list ?? [];

$product_bgs = [];
foreach ($product_list as $item) {
    $pid = $item['product'] ?? 0;
    $bg = $item['product_bg']['url'] ?? '';
    if ($pid && $bg) {
        $product_bgs[$pid] = $bg;
    }
}

$product_ids = array_keys($product_bgs);

$product_query = new WP_Query([
    'post_type'      => 'product',
    'posts_per_page' => -1,
    'post__in'       => $product_ids,
    'orderby'        => 'post__in',
]);

if (!$product_query->have_posts()) return;

?>
<div class="t888-feature-products-wrapper style1" style="background-image: url(''); background-repeat: no-repeat; background-size: cover;">
    <div class="t888-feature-products-inner container">
        <div class="t888-feature-products-content">
            <div class="t888-feature-products-slider">
                <div class="t888-feature-products-title">
                    <h3><?php echo esc_html($main_title); ?></h3>
                </div>

                <div class="swiper  swiper-feature-products"
                     data-items="1"
                     data-loop="true"
                     data-navigation="true"
                     data-effect="slide"
                     data-pagination='{"el": ".t888-pagination-line", "clickable": true}'>
                    <div class="swiper-wrapper products">
                        <?php while ($product_query->have_posts()): $product_query->the_post();
                            $product = wc_get_product(get_the_ID());
                            if (!$product || !$product->is_visible()) continue;

                            $pid = get_the_ID();
                            $title = $product->get_name();
                            $desc = wp_strip_all_tags($product->get_short_description());
                            $bg_url = $product_bgs[$pid] ?? '';
                            ?>
                            <div class="swiper-slide product-item"
                                 data-title="<?php echo esc_attr($title); ?>"
                                 data-desc="<?php echo esc_attr($desc); ?>"
                                 data-bg="<?php echo esc_url($bg_url); ?>">
                                <?php
                                t888f_get_template('woocommerce/loop/grid/grid', '', [
                                    'product' => $product,
                                    'size'    => 'product-list-default',
                                    'style'   => 'default'
                                ], true);
                                ?>
                            </div>
                        <?php endwhile; ?>
                    </div>
                    <div class="swiper-button-prev swiper-button-prev-feature"><i class="las la-angle-left"></i></div>
                    <div class="swiper-button-next swiper-button-next-feature"><i class="las la-angle-right"></i></div>
                </div>
            </div>

            <div class="t888-feature-products-info">
                <h3 id="feature-product-title">&nbsp;</h3>
                <p id="feature-product-desc">&nbsp;</p>
            </div>

            <div class="swiper-pagination t888-pagination-line "></div>
        </div>
    </div>
</div>

<?php wp_reset_postdata(); ?>
