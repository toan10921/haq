<?php
$title = $title ?? 'MOST POPULAR';
$columns = $columns ?? '5';
$product_ids_raw = is_array($sale_products ?? null) ? $sale_products : [];
$product_ids = array_filter(array_map('intval', $product_ids_raw));

?>

<div class="t888-pet-product-module">
    <div class="pet-product-header">
        <div class="header-left">
            <h3 class="pet-product-title">
                <?php echo esc_html($title); ?>
            </h3>
        </div>
        <div class="header-nav">
            <button class="nav-prev"><i class="las la-angle-left"></i></button>
            <button class="nav-next"><i class="las la-angle-right"></i></button>
        </div>
    </div>

    <div class="pet-product-list swiper swiper-pet-product-carousel" data-columns="<?php echo esc_attr($columns); ?>">
        <div class="swiper-wrapper">
            <?php 
            if (!empty($product_ids)):
                foreach ($product_ids as $product_id): 
                    $product = wc_get_product($product_id);
                    if (!$product || !$product->is_visible()) continue;
                    ?>
                    <div class="swiper-slide product-item-wrap">
                        <?php
                        t888f_get_template('woocommerce/loop/grid/grid-pet-product', '', [
                            'product'         => $product,
                            'size'            => 'woocommerce_thumbnail',
                            'style'           => 'default',
                            'show_badge_sale' => $show_badge_sale ?? 'yes',
                            'show_badge_new'  => $show_badge_new ?? 'yes',
                            'show_badge_hot'  => $show_badge_hot ?? 'yes',
                        ], true);
                        ?>
                    </div>
                    <?php 
                endforeach; 
            else:
                echo '<p>' . __('Please select products in the widget settings.', 'nebon') . '</p>';
            endif; 
            ?>
        </div>
    </div>
</div>
