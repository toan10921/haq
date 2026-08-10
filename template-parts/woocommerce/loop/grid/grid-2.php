<?php
if (!isset($product) || !is_a($product, 'WC_Product')) {
    $product = wc_get_product(get_the_ID());
    if (!$product) {
        error_log('[grid.php] Không lấy được $product');
        return;
    }
}
$size = 'product-list-default';
$product_id = $product->get_id();
$product_post_date = get_the_date('Y-m-d', $product->get_id());
$new_days = absint(get_theme_mod('product_new_in_days_general', 30));
$is_new = (strtotime($product_post_date) >= strtotime("-{$new_days} days"));
$product_price = $product->get_price();
$has_price = !empty($product_price);
$is_hot = $product->is_featured();



?>
<div class="grid-product-item product-grid-<?php echo esc_attr($style); ?>">
    <div class="product-item-inner">
        <div class="product-thumbnail-outer position-relative">
            <div class="product-thumbnail-wrapper overflow-hidden position-relative">
                <?php t888f_animation_thumbnail_product(get_the_ID(), $size); ?>
                <?php if ($is_new): ?>
                    <span class="product-badge new"><?php esc_html_e('NEW', 'nebon'); ?></span>
                <?php endif; ?>
                <?php if ($is_hot): ?>
                    <span class="product-badge hot"><?php esc_html_e('HOT', 'nebon'); ?></span>
                <?php endif; ?>

                <?php
                if (!$product->is_type('grouped') && $product->is_on_sale()):
                    $regular_price = floatval($product->get_regular_price());
                    $sale_price = floatval($product->get_sale_price());
                    $discount = ($regular_price > 0 && $sale_price > 0) ? round(100 - ($sale_price / $regular_price) * 100) : 0;
                ?>
                    <span class="product-badge sale">-<?php echo esc_html($discount); ?><?php echo esc_html__('%', 'nebon'); ?></span>
                <?php endif; ?>
                <div class="add-cart-quickview hidden-cart">
                    <?php if ($has_price): ?>
                        <?php woocommerce_template_loop_add_to_cart(); ?>
                    <?php endif; ?>
                    <?php
                    t888f_product_quickview(get_the_ID());
                    ?>
                </div>
            </div>
        </div>
        <h3 class="product-title">
            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
        </h3>
        <span class="product-price d-flex justify-content-center">
            <?php if ($has_price): ?>
                <?php if ($product->is_on_sale()): ?>
                    <span class="regular-price" style="text-decoration: line-through; opacity: 0.6;">
                        <?php echo wc_price($product->get_regular_price()); ?>
                    </span>
                    <span class="sale-price"><?php echo wc_price($product->get_sale_price()); ?></span>
                <?php else: ?>
                    <?php echo wc_price($product_price); ?>
                <?php endif; ?>
            <?php else: ?>
                <span class=""><bdi><?php esc_html_e('Contact', 'nebon'); ?></bdi></span>
            <?php endif; ?>
        </span>

    </div>
</div>