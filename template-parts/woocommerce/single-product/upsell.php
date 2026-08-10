<?php
// global $prodcut;

$product = wc_get_product(get_the_ID());

$number = get_theme_mod('single_number_extra_display', 6);
$upsell_ids = $product->get_upsell_ids();
if (!empty($upsell_ids)) {
    $args = array(
        'post_type'           => 'product',
        'ignore_sticky_posts' => 1,
        'posts_per_page'      => (int) $number,
        'post__in'            => $upsell_ids,
        'post__not_in'        => array($product->get_id()),
        'orderby'             => 'post__in'
    );

    $upsell_query = new WP_Query($args);


    if ($upsell_query->have_posts()): ?>
        <div class="related-products container">
            <div class="related-products">
                <?php
                    $title = get_theme_mod('upsell_products_heading_title', __('You May Also Like', 'nebon'));
                    ?>
                <div class="t888-heading style2">
                    <div class="title-wrapper">
                        <h3 class="title"><?php echo esc_html($title); ?></h3>
                    </div>
                </div>
                <div class="products-slider">
                    <div class="swiper-container eltech888-swiper-slider related-products-slider"
                        data-items="4"
                        data-space="30"
                        data-loop="false"
                        data-navigation=""
                        data-pagination="bullets"
                        data-speed="3000"
                        data-auto="false"
                        data-effect="slide"
                        data-items-widescreen="5"
                        data-items-laptop="4"
                        data-items-tablet-extra="3"
                        data-items-tablet="3"
                        data-items-mobile-extra="2"
                        data-items-mobile="2"
                        data-space-widescreen="40"
                        data-space-laptop="30"
                        data-space-tablet-extra="25"
                        data-space-tablet="20"
                        data-space-mobile-extra="15"
                        data-space-mobile="10">

                        <div class="swiper-wrapper products">
                            <?php while ($upsell_query->have_posts()) :  $upsell_query->the_post(); ?>
                                <div class="swiper-slide product-item">
                                    <?php t888f_get_template('woocommerce/loop/grid/grid', '', [
                                        'product' => wc_get_product(get_the_ID()),
                                        'size'    => get_theme_mod('show_single_size_extra_display', 'product-grid-default'),
                                        'style'   => get_theme_mod('single_item_style_extra_display', 'default')
                                    ], true); ?>
                                </div>
                            <?php endwhile; ?>
                        </div>

                        <!-- Swiper navigation buttons -->

                        <!-- Swiper pagination -->
                        <div class="swiper-pagination t888-pagination-line"></div>

                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

<?php
    wp_reset_postdata();
}
?>