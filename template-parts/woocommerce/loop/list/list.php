<?php
$woocommerce_enable_ajax_add_to_cart = get_option('woocommerce_enable_ajax_add_to_cart') === 'yes';
$product = wc_get_product(get_the_ID());
$attachment_id = $product->get_image_id();
$opt_size_str = get_theme_mod('custom_list_thumbnail_size', '');
$opt_size_arr = [];
if (preg_match('/^(\d{2,5})x(\d{2,5})$/', $opt_size_str, $m)) {
    $opt_size_arr = [(int)$m[1], (int)$m[2]]; // [width, height]
}

if (!empty($opt_size_arr)) {
    $size = $opt_size_arr;
} elseif (empty($size)) {
    $size = 'product-list-default';
}

if ($attachment_id) {
    $full_image_url = wp_get_attachment_image_url($attachment_id, 'full');
} else {
    $full_image_url = get_template_directory_uri() . '/assets/images/328x480.png';
}
$product_id = $product->get_id();
$product_post_date = get_the_date('Y-m-d', $product->get_id());
$new_days = absint(get_theme_mod('product_new_in_days_general', 30));
$is_new = (strtotime($product_post_date) >= strtotime("-{$new_days} days"));
$product_price = $product->get_price();
$has_price = !empty($product_price);
$hover_image_ids = get_post_meta(get_the_ID(), 'product_thumnail_hover', true);
$hover_image_url = '';
$is_hot = $product->is_featured();
if (!empty($hover_image_ids)) {
    if (is_array($hover_image_ids)) {
        $hover_image_url = wp_get_attachment_url($hover_image_ids[0]);
    } else {
        $hover_image_url = wp_get_attachment_url($hover_image_ids);
    }
}

$animation_class = get_theme_mod('thumbnail_animation_general', '');
$enable_ajax_add_to_cart_class = $woocommerce_enable_ajax_add_to_cart ? 'ajax_add_to_cart' : '';
?>

<div class="list-product-item <?php echo esc_attr($enable_ajax_add_to_cart_class); ?> <?php echo esc_attr( $product->get_type() ) ?>">
    <div class="product-thumbnail <?php echo esc_attr($animation_class); ?>">
        <a href="<?php the_permalink(); ?>" class="product-link">
            <?php 
                if($attachment_id) {
                    echo wp_get_attachment_image($attachment_id, $size, false, array(
                        'class' => 'primary-img',
                        'alt' => get_the_title()
                    ));
                } else {
                    $default_image = get_template_directory_uri() . '/assets/images/328x480.png';
                    echo '<img class="primary-img" src="' . esc_url($default_image) . '" alt="' . esc_attr(get_the_title()) . '">';
                }
            ?>
            <?php 
                if(!empty($hover_image_ids)) {
                   echo wp_get_attachment_image($hover_image_ids, $size, false, array(
                        'class' => 'hover-img',
                        'alt' => get_the_title()
                    ));
                }else{
                    $default_image = get_template_directory_uri() . '/assets/images/328x480.png';
                    echo '<img class="hover-img" src="' . esc_url($default_image) . '" alt="' . esc_attr(get_the_title()) . '">';
                }
            ?>
        </a>
        <?php t888f_get_template('woocommerce/product-structure/product-badge', 'list', array(
            'is_new' => $is_new,
            'product' => $product,
            'is_hot' => $is_hot
        ), true); ?>
    </div>

    <div class="product-details">
        <div class="product-category">
            <?php echo wc_get_product_category_list($product->get_id()); ?>
        </div>
        <h6 class="product-title">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h6>
        <?php 
        // display product price
            t888f_get_template('woocommerce/product-structure/product-price', 'list', array(
                'product' => $product,
                'has_price' => $has_price,
                'product_price' => $product_price
            ), true);
        ?>
        <?php 
        // display product variations
        t888f_get_template('woocommerce/product-structure/product-variations', 'list', array(
            'product' => $product
        ), true); ?>
        <div class="product-description">
            <?php echo wp_trim_words(get_the_excerpt(), 20); ?>
        </div>
        <div class="product-meta">
            <span class="product-rating">
                <?php echo wc_get_rating_html($product->get_average_rating()); ?>
            </span>
        </div>

        <div class="product-actions">
            <?php if ($has_price): ?>
                <?php woocommerce_template_loop_add_to_cart(); ?>
            <?php endif; ?>
            <?php t888f_get_template('woocommerce/product-structure/product-wishlist-compare', 'list', array(), true); ?>
        </div>
    </div>
</div>