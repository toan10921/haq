<?php
if (!isset($product) || !is_a($product, 'WC_Product'))
    return;

$product_id = $product->get_id();
$_product = $product;
global $product, $post;
$product = $_product;
$post = get_post($product_id);
setup_postdata($post);

$product_price = $product->get_price();
$has_price = !empty($product_price);
$regular_price = (float) $product->get_regular_price();
$sale_price = (float) $product->get_sale_price();
$is_sale = $product->is_on_sale();
$new_days = absint(get_theme_mod('product_new_in_days_general', 30));
$product_post_date = get_the_date('Y-m-d H:i:s', $product_id);
$is_new = (strtotime($product_post_date) >= strtotime("-{$new_days} days"));
$size = array(327, 482); // Same as hot deals
$attachment_id = $product->get_image_id();

$full_image_url = $attachment_id
    ? wp_get_attachment_image_url($attachment_id, 'full')
    : get_template_directory_uri() . '/assets/images/324x480.png';

$hover_image_ids = get_post_meta($product_id, 'product_thumnail_hover', true);
if (!empty($hover_image_ids)) {
    $hover_url = is_array($hover_image_ids)
        ? wp_get_attachment_url($hover_image_ids[0])
        : wp_get_attachment_url($hover_image_ids);
}
if (empty($hover_url)) {
    $hover_url = wp_get_attachment_image_url($attachment_id, $size);
}
?>


<div class="grid-product-item product woocommerce">
    <div class="product-item-inner">
        <!-- Image & Hover Actions -->
        <div class="product-thumbnail zoomout-thumb">
            <!-- Badges -->
            <div class="product-badges-wrap">
                <!-- DEBUG: Check conditions -->
                <!-- is_sale=<?php echo $is_sale ? 'yes' : 'no'; ?>, show_badge_sale=<?php echo $show_badge_sale; ?> -->
                <!-- is_new=<?php echo $is_new ? 'yes' : 'no'; ?>, show_badge_new=<?php echo $show_badge_new; ?> -->
                <!-- is_featured=<?php echo $product->is_featured() ? 'yes' : 'no'; ?>, show_badge_hot=<?php echo $show_badge_hot; ?> -->

                <?php if ($is_sale && ($show_badge_sale ?? 'yes') === 'yes'): ?>
                    <span class="product-badge sale"><?php esc_html_e('sale', 'nebon'); ?></span>
                <?php endif; ?>
                <?php if ($is_new && ($show_badge_new ?? 'yes') === 'yes'): ?>
                    <span class="product-badge new"><?php esc_html_e('new', 'nebon'); ?></span>
                <?php endif; ?>
                <?php if ($product->is_featured() && ($show_badge_hot ?? 'yes') === 'yes'): ?>
                    <span class="product-badge hot"><?php esc_html_e('hot', 'nebon'); ?></span>
                <?php endif; ?>
            </div>

            <a href="<?php echo esc_url(get_permalink($product_id)); ?>" class="product-link">
                <img class="primary-img" src="<?php echo esc_url($full_image_url); ?>"
                    alt="<?php echo esc_attr($product->get_name()); ?>">
                <img class="hover-img" src="<?php echo esc_url($hover_url ?: $full_image_url); ?>"
                    alt="<?php echo esc_attr($product->get_name()); ?>">
            </a>
            <div class="hover-actions-group">
                <div class="action-btn cart-btn" title="<?php esc_attr_e('Add to Cart', 'nebon'); ?>">
                    <div class="icon-layer"><i class="lab la-opencart"></i></div>
                    <?php if ($has_price): ?>
                        <div class="btn-layer">
                            <?php woocommerce_template_loop_add_to_cart(); ?>
                        </div>
                    <?php endif; ?>
                </div>
                <?php
                $in_wishlist = false;
                if (function_exists('yith_wcwl_is_product_in_wishlist')) {
                    $in_wishlist = yith_wcwl_is_product_in_wishlist($product_id);
                }
                $wishlist_btn_class = $in_wishlist ? 'is-added' : '';
                $heart_class = $in_wishlist ? 'las la-heart' : 'lar la-heart';
                ?>
                <div class="action-btn wishlist-btn <?php echo esc_attr($wishlist_btn_class); ?>"
                    title="<?php esc_attr_e('Wishlist', 'nebon'); ?>"
                    data-product-id="<?php echo esc_attr($product_id); ?>">
                    <div class="icon-layer"><i class="<?php echo esc_attr($heart_class); ?>"></i></div>
                    <div class="btn-layer">
                        <?php echo do_shortcode('[yith_wcwl_add_to_wishlist product_id="' . $product_id . '"]'); ?>
                    </div>
                </div>


                <div class="action-btn compare-btn" title="<?php esc_attr_e('Compare', 'nebon'); ?>">
                    <div class="icon-layer"><i class="las la-sync-alt"></i></div>
                    <div class="btn-layer">
                        <?php echo do_shortcode('[yith_compare_button product_id="' . $product_id . '"]'); ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="product-content">
            <h3 class="product-title">
                <a href="<?php the_permalink($product_id); ?>"><?php echo esc_html($product->get_name()); ?></a>
            </h3>

            <div class="product-rating">
                <div class="custom-star-rating">
                    <?php
                    $average = $product->get_average_rating() ?: 5; // Default to 5 for "mockup" look if no rating
                    for ($i = 1; $i <= 5; $i++) {
                        if ($i <= $average) {
                            echo '<i class="las la-star"></i>';
                        } else {
                            echo '<i class="las la-star" style="opacity: 0.3;"></i>'; // Dimmed solid star for empty
                        }
                    }
                    ?>
                </div>
            </div>

            <!-- Price -->
            <span class="product-price">
                <?php
                if ($has_price) {
                    if ($product->is_type('variable')) {
                        echo $product->get_price_html();
                    } elseif ($is_sale) {
                        echo '<ins>' . wc_price($sale_price) . '</ins>';
                        echo '<del>' . wc_price($regular_price) . '</del>';
                    } else {
                        echo wc_price($product_price);
                    }
                } else {
                    echo '<span><bdi>' . esc_html__('Contact', 'nebon') . '</bdi></span>';
                }
                ?>
            </span>
        </div>
    </div>
</div>
<?php wp_reset_postdata(); ?>