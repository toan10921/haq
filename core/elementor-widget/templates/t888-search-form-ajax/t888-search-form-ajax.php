<?php

/**
 * Template for displaying the search form with AJAX functionality.
 */


if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if ($query->have_posts()) :
?>
    <div class="custom-product-list">
        <ul class="product-list p-0">
            <?php
            while ($query->have_posts()) :
                $query->the_post();
            ?>
                <li class="product-item">
                    <div class="product-thumbnail">
                        <a href="<?php the_permalink(); ?>">
                            <?php if (has_post_thumbnail()) : ?>
                                <?php the_post_thumbnail('product-search-ajax', array('style' => 'width: 100%; height: auto;')); ?>
                            <?php else : ?>
                                <img src="<?php echo esc_url($default_image); ?>" alt="Default Image" style="width: 100%; height: auto;">
                            <?php endif; ?>
                        </a>
                    </div>
                    <div class="product-info">
                        <h6 class="product-title">
                            <a class="primary" href="<?php the_permalink(); ?>">
                                <?php the_title(); ?>
                            </a>
                        </h6>
                        <span class="product-price">
                            <?php echo wc_get_product(get_the_ID())->get_price_html(); ?>
                        </span>
                    </div>
                </li>
            <?php
            endwhile;
            wp_reset_postdata();
            ?>
        </ul>
    </div>
    <a href="<?php echo esc_url($param_url); ?>" class="btn-view-all button d-block text-center fw-normal text-uppercase">
        <?php echo esc_html__('View All Products', 'nebon'); ?>
    </a>
<?php
else :
?>
    <div class="no-results">
        <p class="m-0 text-center"><?php echo esc_html__('No products found matching your search criteria.', 'nebon'); ?></p>
    </div>
<?php
endif;
