<?php

$current_id = isset($post_id) ? (int) $post_id : (int) get_queried_object_id();
if ($current_id <= 0 || get_post_type($current_id) !== 'post') {
    return;
}

$product_limit = 6;
$post_limit = 4;
$products = [];

if (function_exists('wc_get_products')) {
    $products = wc_get_products([
        'status' => 'publish',
        'limit' => $product_limit,
        'featured' => true,
        'orderby' => 'date',
        'order' => 'DESC',
        'return' => 'objects',
    ]);

    if (empty($products)) {
        $products = wc_get_products([
            'status' => 'publish',
            'limit' => $product_limit,
            'orderby' => 'date',
            'order' => 'DESC',
            'return' => 'objects',
        ]);
    }
}

$cat_ids = wp_get_post_categories($current_id);
$related_posts = [];

if (!empty($cat_ids)) {
    $related_query = new WP_Query([
        'post_type' => 'post',
        'post_status' => 'publish',
        'posts_per_page' => $post_limit,
        'post__not_in' => [$current_id],
        'ignore_sticky_posts' => true,
        'category__in' => array_map('absint', $cat_ids),
        'no_found_rows' => true,
    ]);
    $related_posts = $related_query->posts;
}

wp_reset_postdata();

if (empty($products) && empty($related_posts)) {
    return;
}

$fallback_thumb = get_theme_mod('general_post_thumbnail_default', '');
if (!$fallback_thumb) {
    $fallback_thumb = get_template_directory_uri() . '/assets/images/505x273.png';
}
?>
<div class="post-rail">
    <?php if (!empty($products)) : ?>
        <section class="post-rail-block" aria-labelledby="post-rail-products-title">
            <h2 id="post-rail-products-title" class="post-rail-heading"><?php esc_html_e('Sản phẩm nổi bật', 'nebon'); ?></h2>
            <div class="post-rail-products">
                <?php foreach ($products as $rail_product) :
                    if (!is_a($rail_product, 'WC_Product')) {
                        continue;
                    }
                    $product_name = $rail_product->get_name();
                    $product_link = $rail_product->get_permalink();
                    ?>
                    <a class="post-rail-product" href="<?php echo esc_url($product_link); ?>">
                        <span class="post-rail-product__media">
                            <?php
                            echo $rail_product->get_image('woocommerce_thumbnail', [
                                'alt' => $product_name,
                                'loading' => 'lazy',
                            ]);
                            ?>
                        </span>
                        <span class="post-rail-product__name"><?php echo esc_html($product_name); ?></span>
                    </a>
                <?php endforeach; ?>
            </div>
        </section>
    <?php endif; ?>

    <?php if (!empty($related_posts)) : ?>
        <section class="post-rail-block" aria-labelledby="post-rail-posts-title">
            <h2 id="post-rail-posts-title" class="post-rail-heading"><?php esc_html_e('Bài viết', 'nebon'); ?></h2>
            <div class="post-rail-posts">
                <?php foreach ($related_posts as $related_post) :
                    $related_id = (int) $related_post->ID;
                    $related_title = get_the_title($related_id);
                    $related_link = get_permalink($related_id);
                    $related_thumb = get_the_post_thumbnail_url($related_id, 'medium');
                    if (!$related_thumb) {
                        $related_thumb = $fallback_thumb;
                    }
                    ?>
                    <a class="post-rail-post" href="<?php echo esc_url($related_link); ?>">
                        <span class="post-rail-post__media">
                            <img src="<?php echo esc_url($related_thumb); ?>" alt="<?php echo esc_attr($related_title); ?>" loading="lazy">
                        </span>
                        <span class="post-rail-post__body">
                            <span class="post-rail-post__title"><?php echo esc_html($related_title); ?></span>
                            <time class="post-rail-post__date" datetime="<?php echo esc_attr(get_the_date('c', $related_id)); ?>">
                                <?php echo esc_html(get_the_date('d/m/Y', $related_id)); ?>
                            </time>
                        </span>
                    </a>
                <?php endforeach; ?>
            </div>
        </section>
    <?php endif; ?>
</div>
