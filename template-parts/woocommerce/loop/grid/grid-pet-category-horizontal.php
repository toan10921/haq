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
$is_new = (strtotime(get_the_date('Y-m-d H:i:s', $product_id)) >= strtotime("-{$new_days} days"));

$attachment_id = $product->get_image_id();
$full_image_url = $attachment_id
    ? wp_get_attachment_image_url($attachment_id, 'medium')
    : get_template_directory_uri() . '/assets/images/324x480.png';

// Category
$terms = get_the_terms($product_id, 'product_cat');
$cat_names = [];
if ($terms && !is_wp_error($terms)) {
    foreach ($terms as $term) {
        if ($term->slug !== 'uncategorized') {
            $cat_names[] = $term->name;
        }
    }
}
$cat_output = implode(', ', $cat_names);

// Wishlist
$in_wishlist = function_exists('yith_wcwl_is_product_in_wishlist') && yith_wcwl_is_product_in_wishlist($product_id);
$heart_class = $in_wishlist ? 'las la-heart' : 'lar la-heart';
$wishlist_class = $in_wishlist ? 'hcard-action-btn wl-btn is-added' : 'hcard-action-btn wl-btn';

// Rating
$average = $product->get_average_rating() ?: 5;

// Cart URL & button type
$cart_url = $product->add_to_cart_url();
$is_purchasable = $product->is_purchasable() && $product->is_in_stock();
$cart_classes = 'hcard-action-btn cart-btn add_to_cart_button';
if ($is_purchasable && !$product->is_type('variable')) {
    $cart_classes .= ' ajax_add_to_cart';
}
?>
<div class="grid-product-item product woocommerce grid-horizontal-card">

    <div class="hcard-image-col">

        <div class="product-badges-wrap">
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

        <a href="<?php echo esc_url(get_permalink($product_id)); ?>" class="hcard-img-link">
            <img src="<?php echo esc_url($full_image_url); ?>" alt="<?php echo esc_attr($product->get_name()); ?>"
                loading="lazy">
        </a>
    </div>

    <div class="hcard-info-col">


        <?php if (!empty($cat_output)): ?>
            <div class="hcard-category"><?php echo esc_html__('For', 'nebon') . ' ' . esc_html($cat_output); ?></div>
        <?php else: ?>
            <div class="hcard-category">&nbsp;</div>
        <?php endif; ?>

        <h3 class="hcard-title">
            <a
                href="<?php echo esc_url(get_permalink($product_id)); ?>"><?php echo esc_html($product->get_name()); ?></a>
        </h3>

        <div class="hcard-rating">
            <?php for ($i = 1; $i <= 5; $i++): ?>
                <i class="las la-star<?php echo $i <= $average ? '' : ' empty'; ?>"></i>
            <?php endfor; ?>
        </div>

        <div class="hcard-price">
            <?php
            if ($has_price) {
                if ($product->is_type('variable')) {
                    echo $product->get_price_html();
                } elseif ($is_sale) {
                    echo '<ins>' . wc_price($sale_price) . '</ins>';
                    echo ' <del>' . wc_price($regular_price) . '</del>';
                } else {
                    echo wc_price($product_price);
                }
            } else {
                echo '<span><bdi>' . esc_html__('Contact', 'nebon') . '</bdi></span>';
            }
            ?>
        </div>

        <div class="hcard-actions">

            <?php if ($has_price): ?>
                <a href="<?php echo esc_url($cart_url); ?>" class="<?php echo esc_attr($cart_classes); ?>"
                    data-product_id="<?php echo esc_attr($product_id); ?>" data-quantity="1"
                    aria-label="<?php esc_attr_e('Add to cart', 'nebon'); ?>"
                    title="<?php esc_attr_e('Add to cart', 'nebon'); ?>">
                    <i class="lab la-opencart"></i>
                </a>
            <?php else: ?>
                <span class="hcard-action-btn disabled" title="<?php esc_attr_e('Unavailable', 'nebon'); ?>">
                    <i class="lab la-opencart"></i>
                </span>
            <?php endif; ?>

            <span class="<?php echo esc_attr($wishlist_class); ?>"
                title="<?php esc_attr_e('Add to Wishlist', 'nebon'); ?>"
                data-product-id="<?php echo esc_attr($product_id); ?>">
                <i class="<?php echo esc_attr($heart_class); ?>"></i>
            </span>

            <span class="hcard-action-btn compare-btn" title="<?php esc_attr_e('Compare', 'nebon'); ?>"
                data-product-id="<?php echo esc_attr($product_id); ?>">
                <i class="las la-sync-alt"></i>
            </span>

        </div>
    </div>

</div>
<?php wp_reset_postdata(); ?>