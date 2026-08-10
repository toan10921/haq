<?php

/**
 * Template: Discount Product Layout - Style 1
 *
 * @var $settings (array) Elementor widget settings
 */

$bg_url = $background_image['url'] ?? '';
$bg_pos_desktop = $background_position ?? 'right-center';
$bg_pos_mobile = $background_position_mobile ?? 'left center';
?>


<div class="t888-discount-wrapper"
    style="background-image: url('<?php echo esc_url($bg_url); ?>'); 
            background-position: <?php echo esc_attr($bg_pos_desktop); ?>;">

    <div class="t888-left">
        <?php if ($left_title_1): ?><div class="title1-left"><?php echo esc_html($left_title_1); ?></div><?php endif; ?>
        <?php if ($left_title_2): ?><div class="title2-left"><?php echo esc_html($left_title_2); ?></div><?php endif; ?>
        <?php if ($left_title_3): ?><div class="title3-left"><?php echo esc_html($left_title_3); ?></div><?php endif; ?>
    </div>

    <div class="t888-right">
        <?php if ($right_title_1): ?><div class="title1-right"><?php echo esc_html($right_title_1); ?></div><?php endif; ?>
        <?php if ($right_title_2): ?><div class="title2-right"><?php echo esc_html($right_title_2); ?></div><?php endif; ?>

        <?php
        $product_query = new WP_Query([
            'post_type'      => 'product',
            'posts_per_page' => -1,
            'post__in'       => wc_get_product_ids_on_sale(),
            'meta_query'     => WC()->query->get_meta_query(),
        ]);
        ?>

        <?php if ($product_query->have_posts()): ?>
            <div class="products-slider">
                <div class="swiper-container eltech888-swiper-slider swiper-discount-products"
                    data-items="1"
                    data-loop="true"
                    data-navigation="true"
                    data-effect="slide"
                    >
                    <div class="swiper-wrapper products">
                        <?php while ($product_query->have_posts()): $product_query->the_post(); ?>
                            <?php
                            $product = wc_get_product(get_the_ID());
                            if (!$product || !$product->is_visible()) continue;
                            ?>
                            <div class="swiper-slide product-item">
                                <?php
                                t888f_get_template('woocommerce/loop/grid/grid-boxsale', '', [
                                    'product' => $product,
                                    'size'    => 'product-grid-default',
                                    'style'   => 'default'
                                ], true);
                                ?>
                            </div>
                        <?php endwhile; ?>
                    </div>
                    <div class="swiper-button-prev swiper-button-prev-discount"><i class="las la-angle-left"></i></div>
                    <div class="swiper-button-next swiper-button-next-discount"><i class="las la-angle-right"></i></div>

                </div>
            </div>
        <?php else: ?>
            <p><?php _e('No discounted products found.', 'nebon'); ?></p>
        <?php endif; ?>
        <?php wp_reset_postdata(); ?>
        <div class="t888-discount-shadow" style="background-image: url('<?php echo esc_url(get_template_directory_uri()); ?>/assets/images/shadow.png');"></div>


    </div>

</div>