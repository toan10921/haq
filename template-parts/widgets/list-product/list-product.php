<?php
extract($data);
if (!defined('ABSPATH')) exit;

$query_args = array(
    'post_type'      => 'product',
    'posts_per_page' => $number,
);

if ($style == 'top-rate') {
    $query_args['meta_key'] = '_wc_average_rating';
    $query_args['orderby'] = 'meta_value_num';
    $query_args['order'] = 'DESC';
} elseif ($style == 'best-seller') {
    $query_args['meta_key'] = 'total_sales';
    $query_args['orderby'] = 'meta_value_num';
    $query_args['order'] = 'DESC';
}

$query = new WP_Query($query_args);
$default_image = get_template_directory_uri() . '/assets/images/100x150.png';
?>

<div class="custom-product-list <?php echo esc_attr($style); ?>">
    <h5 class="widget-title"><?php echo esc_html($title); ?></h5>

    <ul class="product-list">
        <?php if ($query->have_posts()) : ?>
            <?php while ($query->have_posts()) : $query->the_post(); ?>
                <li class="product-item">
                    <div class="product-thumbnail">
                        <a class="default-zoom" href="<?php the_permalink(); ?>">
                            <?php if (has_post_thumbnail()) : ?>
                                <?php the_post_thumbnail('shop_thumbnail', array('class' => 'img-responsive', 'alt' => get_the_title())); ?>
                            <?php else : ?>
                                <img src="<?php echo esc_url($default_image); ?>" alt="<?php echo get_the_title(); ?>" style="width: 100%; height: auto;">
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
                        <div class="product-rating">
                            <?php 
                                $product = wc_get_product(get_the_ID());
                                echo wp_kses_post($product->get_average_rating() ? wc_get_rating_html($product->get_average_rating()) : ''); 
                                $review_count = $product->get_review_count();
                                if ($review_count > 0) :
                            ?>
                                <span class="review-count">
                                    <?php echo esc_html($review_count); ?>
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                </li>
            <?php endwhile; ?>
        <?php else : ?>
            <p><?php esc_html_e('No products found', 'nebon'); ?></p>
        <?php endif; ?>
    </ul>
</div>

<?php wp_reset_postdata(); ?>