<?php
global $product;

if (!$product || !is_a($product, 'WC_Product')) {
    return;
}


$terms = get_the_terms($product->get_id(), 'product_cat');
$leaf_terms = [];

if ($terms && !is_wp_error($terms)) {
    foreach ($terms as $term) {
        $children = get_term_children($term->term_id, 'product_cat');
        if (empty($children)) {
            $leaf_terms[] = $term->term_id;
        }
    }
}


if (empty($leaf_terms)) {
    return;
}

$number = get_theme_mod('single_number_extra_display', 6);

$args = [
    'post_type' => 'product',
    'post_status' => 'publish',
    'posts_per_page' => (int) $number,
    'post__not_in' => [$product->get_id()],
    'tax_query' => [
        [
            'taxonomy' => 'product_cat',
            'field'    => 'term_id',
            'terms'    => $leaf_terms,
            'operator' => 'IN',
        ]
    ],
];

$related_query = new WP_Query($args);

if ($related_query->have_posts()) : ?>
    <div class="related-products container">
        <?php
        $title = get_theme_mod('related_products_heading_title', __('You May Also Like', 'nebon'));
        // $icon_class = get_theme_mod('related_products_heading_icon', 'las la-rainbow');
        // ?>

        <div class="t888-heading style2">
            <div class="title-wrapper">
                <h3 class="title"><?php echo esc_html($title); ?></h3>
            </div>
        </div>
        <div class="products-slider">
            <div class="swiper-container eltech888-swiper-slider related-products-slider"
                data-items="4"
                data-space="0"
                data-loop="false"
                data-navigation="true"
                data-pagination="bullets"
                data-speed="3000"
              
                data-effect="slide"
                data-items-widescreen="5"
                data-items-laptop="4"
                data-items-tablet-extra="3"
                data-items-tablet="3"
                data-items-mobile-extra="2"
                data-items-mobile="2"
                data-space-widescreen="1"
                data-space-laptop="1"
                data-space-tablet-extra="1"
                data-space-tablet="1"
                data-space-mobile-extra="1"
                data-space-mobile="1">

                <div class="swiper-wrapper products">
                    <?php while ($related_query->have_posts()) : $related_query->the_post();
                        $rel_product = wc_get_product(get_the_ID());
                        if (!$rel_product || !$rel_product->is_visible()) continue;
                    ?>
                        <div class="swiper-slide product-item">
                            <?php
                            t888f_get_template('woocommerce/loop/grid/grid', '', [
                                'product' => $rel_product,
                                'compact_card' => true,
                                'contact_button_text' => __('Liên hệ', 'nebon'),
                                'contact_button_url' => '#',
                                'size'    => get_theme_mod('show_single_size_extra_display', 'product-grid-default'),
                                'style'   => get_theme_mod('single_item_style_extra_display', 'default')
                            ], true);
                            ?>
                        </div>
                    <?php endwhile; ?>
                </div>

                <div class="swiper-pagination t888-pagination-line"></div>
            </div>


        </div>
    </div>
<?php endif;

wp_reset_postdata();
?>
