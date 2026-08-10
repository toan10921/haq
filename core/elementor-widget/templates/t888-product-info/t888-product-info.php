<?php
$product_id = !empty($product_id) ? absint($product_id) : 0;
?>

<div class="t888-product-info-widget">
    <div class="t888-product-info-products">
        <?php
        if ($product_id > 0) {
            $product = wc_get_product($product_id);
            if ($product && $product->is_visible()) {
                t888f_get_template('woocommerce/loop/grid/grid-pet-category', '', [
                    'product' => $product,
                    'show_badge_sale' => $show_badge_sale ?? 'yes',
                    'show_badge_new' => $show_badge_new ?? 'yes',
                    'show_badge_hot' => $show_badge_hot ?? 'yes',
                ], true);
            } else {
                echo '<p class="t888-product-info-empty">' . esc_html__('Selected product is not available.', 'nebon') . '</p>';
            }
        } else {
            echo '<p class="t888-product-info-empty">' . esc_html__('Please select a product in widget settings.', 'nebon') . '</p>';
        }
        ?>
    </div>
</div>

