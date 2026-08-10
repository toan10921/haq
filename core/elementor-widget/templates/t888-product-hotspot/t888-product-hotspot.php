<?php
$main_image_url = '';
if (is_array($main_image) && !empty($main_image['url'])) {
    $main_image_url = $main_image['url'];
} elseif (is_string($main_image) && $main_image !== '') {
    $main_image_url = $main_image;
}
$background_position = $background_position ?? 'center center';
$hotspots = $hotspots ?? [];
?>

<div class="t888-hotspot-wrapper"
     style="background-image:url('<?php echo esc_url($main_image_url); ?>');
            background-position:<?php echo esc_attr($background_position); ?>;">
    <?php foreach ($hotspots as $spot) :
        $product_id = $spot['product_id'] ?? null;
        $top = intval($spot['position_top']);
        $left = intval($spot['position_left']);
        $product = wc_get_product($product_id);

        if (!$product) continue;

        $image_id = $product->get_image_id();
        $image_url = wp_get_attachment_image_url($image_id, 'medium_large');
        $product_title = $product->get_name();
        $product_price_html = $product->get_price_html();
        $product_link = get_permalink($product_id);
    ?>
        <div class="t888-hotspot-point" style="top: <?php echo esc_attr( $top ); ?>px; left: <?php echo esc_attr( $left ); ?>px;">
            <div class="t888-hotspot-circle"></div>

            <div class="t888-hotspot-popup">
                <a href="<?php echo esc_url($product_link); ?>" class="t888-product-thumb">
                    <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($product_title); ?>">
                </a>
                <div class="t888-product-hotspot-info">
                    <a href="<?php echo esc_url($product_link); ?>" class="t888-product-link">
                        <div class="t888-product-title"><?php echo esc_html($product_title); ?></div>
                    </a>
                    <div class="t888-product-price"><?php echo wp_kses_post( $product_price_html ); ?></div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>