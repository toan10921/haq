<?php
if (!isset($product) || !is_a($product, 'WC_Product')) return;

$product_id     = $product->get_id();
$product_price  = $product->get_price();
$has_price      = !empty($product_price);
$regular_price  = (float) $product->get_regular_price();
$sale_price     = (float) $product->get_sale_price();
$percent        = ($regular_price > 0 && $sale_price) ? round((($regular_price - $sale_price) / $regular_price) * 100) : 0;
$size           = $size ?? 'woocommerce_thumbnail';
$is_sale        = $product->is_on_sale();
$new_days = absint(get_theme_mod('product_new_in_days_general', 30));   
if(empty($product_post_date)) {
    $product_post_date = get_the_date('Y-m-d H:i:s', $product_id);
}
$is_new = (strtotime($product_post_date) >= strtotime("-{$new_days} days"));
$size           = array(327, 482);
$attachment_id  = $product->get_image_id();
$hover_image_url = '';

$full_image_url = $attachment_id
    ? wp_get_attachment_image_url($attachment_id, 'full')
    : get_template_directory_uri() . '/assets/images/324x480.png';

$hover_image_ids = get_post_meta(get_the_ID(), 'product_thumnail_hover', true);
if (!empty($hover_image_ids)) {
    $hover_url = is_array($hover_image_ids)
        ? wp_get_attachment_url($hover_image_ids[0])
        : wp_get_attachment_url($hover_image_ids);
}
if (empty($hover_url)) {
    $hover_url = wp_get_attachment_image_url($product->get_image_id(), $size);
}

$animation_class = get_theme_mod('thumbnail_animation_general', '');

// Lấy thời gian sale để countdown
$sale_end_timestamp = $sale_to ?? get_post_meta($product_id, '_sale_price_dates_to', true);
$data_deadline = $sale_end_timestamp ? ($sale_end_timestamp * 1000) : '';
?>

<div class="grid-product-item">
    <div class="product-item-inner">
        <!-- Badges Container -->
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

        <div class="product-thumbnail zoomout-thumb">
            <a href="<?php the_permalink($product_id); ?>" class="product-link">
                <img class="primary-img" src="<?php echo esc_url($full_image_url); ?>" alt="<?php the_title(); ?>">
                <img class="hover-img" src="<?php echo esc_url($hover_url ?: $full_image_url); ?>" alt="<?php the_title(); ?>">
            </a>
        </div>

        <div class="product-content">
            <h3 class="product-title">
                <a href="<?php the_permalink($product_id); ?>">
                    <?php echo esc_html($product->get_name()); ?>
                </a>
            </h3>

            <div class="product-rating">
                <div class="star-rating" style="display: flex; gap: 2px;">
                    <?php 
                    $average = $product->get_average_rating();
                    for($i=1; $i<=5; $i++) {
                        if ($i <= $average) {
                            echo '<i class="las la-star" style="color: inherit; font-size: inherit;"></i>';
                        } else {
                            echo '<i class="lar la-star" style="color: #ccc; font-size: inherit;"></i>';
                        }
                    }
                    ?>
                </div>
            </div>

            <span class="product-price">
                <?php 
                if ($has_price) {
                    if ($product->is_type('variable')) {
                        echo $product->get_price_html();
                    } elseif ($is_sale) {
                        // Display sale price before regular price
                        echo '<ins>' . wc_price($sale_price) . '</ins>';
                        echo '<del>' . wc_price($regular_price) . '</del>';
                    } else {
                        // Regular product
                        echo wc_price($product_price);
                    }
                } else {
                    echo '<span><bdi>' . esc_html__('Contact', 'nebon') . '</bdi></span>';
                }
                ?>
            </span>

            <?php if ($data_deadline): ?>
                <div class="hotdeal-countdown" data-deadline="<?php echo esc_attr($data_deadline); ?>">
                    <i class="las la-stopwatch"></i>
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
            <?php endif; ?>
        </div>
    </div>
</div>
