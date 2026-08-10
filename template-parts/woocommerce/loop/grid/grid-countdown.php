<?php
if (!isset($product) || !is_a($product, 'WC_Product')) return;

$product_id     = $product->get_id();
$product_price = $product->get_price();
$has_price = !empty($product_price);
$regular_price = (float) $product->get_regular_price();
$sale_price = (float) $product->get_sale_price();
$percent        = ($regular_price > 0 && $sale_price) ? round((($regular_price - $sale_price) / $regular_price) * 100) : 0;
$size           = $args['size'] ?? 'woocommerce_thumbnail';
$is_sale        = $product->is_on_sale();
$new_days = absint(get_theme_mod('product_new_in_days_general', 30));   
if(empty($product_post_date)) {
    $product_post_date = get_the_date('Y-m-d H:i:s', $product_id);
}
$is_new = (strtotime($product_post_date) >= strtotime("-{$new_days} days"));
$size = array(327, 482);
$attachment_id = $product->get_image_id();
if ($attachment_id) {
    $full_image_url = wp_get_attachment_image_url($attachment_id, 'full');
} else {
    $full_image_url = get_template_directory_uri() . '/assets/images/324x480.png';
}
$hover_image_ids = get_post_meta(get_the_ID(), 'product_thumnail_hover', true);
$hover_image_url = '';

$hover_url = '';
if (!empty($hover_image_ids)) {
    $hover_url = is_array($hover_image_ids)
        ? wp_get_attachment_url($hover_image_ids[0])
        : wp_get_attachment_url($hover_image_ids);
}
if (!$hover_url) $hover_url = wp_get_attachment_image_url($product->get_image_id(), $size);

$animation_class = get_theme_mod('thumbnail_animation_general', '');
?>

<div class="item-countdown">
    <div class="product-item-inner">
       
        <?php if ($is_new): ?>
            <span class="product-badge new"><?php esc_html_e('NEW', 'nebon'); ?></span>
        <?php endif; ?>

        <?php if ($is_sale && $percent > 0): ?>
            <span class="product-badge sale">-<?php echo esc_html($percent); ?><?php echo esc_html__('%', 'nebon'); ?></span>
        <?php endif; ?>

        <div class="product-thumbnail zoomout-thumb">
            <a href="<?php the_permalink($product_id); ?>" class="product-link">
                <img class="primary-img" src="<?php echo esc_url($full_image_url); ?>" alt="<?php the_title(); ?>">
                <img class="hover-img" src="<?php echo esc_url($hover_image_url ?: $full_image_url); ?>" alt="<?php the_title(); ?>">
            </a>
             <?php
            $sale_end_timestamp = $sale_to ?? get_post_meta($product_id, '_sale_price_dates_to', true);

           $data_deadline = $sale_end_timestamp ? ($sale_end_timestamp * 1000) : '';

            ?>

            <div class="hotdeal-countdown countdown-productstabs-style4" data-deadline="<?php echo esc_attr($data_deadline); ?>">

                <i class="las la-stopwatch"></i>
                <div class="countdown-item">
                    <strong class="countdown-days">00</strong><span><?php echo esc_html__('days', 'nebon'); ?></span>
                </div>
                <div class="countdown-item">
                    <strong class="countdown-hours">00</strong><span><?php echo esc_html__('hurs', 'nebon'); ?></span>
                </div>
                <div class="countdown-item">
                    <strong class="countdown-mins">00</strong><span><?php echo esc_html__('mins', 'nebon'); ?></span>
                </div>
                <div class="countdown-item">
                    <strong class="countdown-secs">00</strong><span><?php echo esc_html__('secs', 'nebon'); ?></span>
                </div>
            </div>
        </div>
        <div class="product-content">


            <h3 class="product-title">
                <a href="<?php the_permalink($product_id); ?>">
                    <?php echo esc_html($product->get_name()); ?>
                </a>
            </h3>

            <span class="product-price">
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
</div>