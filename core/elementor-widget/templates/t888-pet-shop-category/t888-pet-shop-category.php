<?php
$title = $title ?? 'DOG SHOP';
$subtitle_top = $subtitle_top ?? 'BEST QUALITY';
$subtitle_bottom = $subtitle_bottom ?? 'PET ACCESSORIES';
$discount_top = $discount_top ?? 'UP TO';
$discount_bottom = $discount_bottom ?? '50% OFF';
$bg_color = $bg_color ?? '#41a8c0';
$bg_image_url = $bg_image['url'] ?? '';

$pet_image_url = $pet_image['url'] ?? '';

$product_ids_raw = is_array($products ?? null) ? $products : [];
$product_ids = array_filter(array_map('intval', $product_ids_raw));

$brands = is_array($brands ?? null) ? $brands : [];
$show_button = $show_button ?? 'yes';
?>

<div class="t888-pet-shop-category">
    <div class="shop-category-inner d-flex flex-wrap">
        <!-- Left Banner -->
        <div class="shop-category-banner" style="<?php if ($bg_image_url): ?>background-image: url('<?php echo esc_url($bg_image_url); ?>');<?php endif; ?>">
            <div class="banner-bg-color" style="background-color: <?php echo esc_attr($bg_color); ?>;"></div>
            
            <div class="banner-content text-center">
                <?php if ($title): ?>
                    <h3 class="banner-title"><?php echo esc_html($title); ?></h3>
                <?php endif; ?>

                <?php if ($pet_image_url): ?>
                    <img src="<?php echo esc_url($pet_image_url); ?>" alt="<?php echo esc_attr($title); ?>" class="banner-image">
                <?php endif; ?>

                <div class="banner-text">
                    <?php if ($subtitle_top || $subtitle_bottom): ?>
                        <div class="subtitle">
                            <?php echo esc_html($subtitle_top); ?><br>
                            <?php echo esc_html($subtitle_bottom); ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($discount_top || $discount_bottom): ?>
                        <div class="discount">
                            <span class="discount-top"><?php echo esc_html($discount_top); ?></span>
                            <span class="discount-bottom"><?php echo esc_html($discount_bottom); ?></span>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($show_button === 'yes' && !empty($button_text)): 
                        $btn_url = $button_link['url'] ?? '#';
                        $btn_target = !empty($button_link['is_external']) ? ' target="_blank"' : '';
                        $btn_nofollow = !empty($button_link['nofollow']) ? ' rel="nofollow"' : '';
                    ?>
                        <a href="<?php echo esc_url($btn_url); ?>" class="banner-btn"<?php echo $btn_target . $btn_nofollow; ?>>
                            <?php echo esc_html($button_text); ?>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Right Content -->
        <div class="shop-category-content">
            <!-- Products Grid -->
            <div class="shop-category-products">
                <?php 
                if (!empty($product_ids)):
                    foreach ($product_ids as $product_id): 
                        $product = wc_get_product($product_id);
                        if (!$product || !$product->is_visible()) continue;
                        
                        t888f_get_template('woocommerce/loop/grid/grid-pet-category', '', [
                            'product'         => $product,
                            'show_badge_sale' => $show_badge_sale ?? 'yes',
                            'show_badge_new'  => $show_badge_new ?? 'yes',
                            'show_badge_hot'  => $show_badge_hot ?? 'yes',
                        ], true);
                    endforeach; 
                else:
                    echo '<p style="padding: 20px;">' . __('Please select products in the widget settings.', 'nebon') . '</p>';
                endif; 
                ?>
            </div>

            <!-- Brands Log Grid -->
            <?php if (!empty($brands)): ?>
                <div class="shop-category-brands">
                    <?php foreach ($brands as $brand): 
                        $brand_img = $brand['brand_logo']['url'] ?? '';
                        $brand_link = $brand['brand_link']['url'] ?? '#';
                        $target = ($brand['brand_link']['is_external'] ?? false) ? ' target="_blank"' : '';
                        $nofollow = ($brand['brand_link']['nofollow'] ?? false) ? ' rel="nofollow"' : '';
                        if ($brand_img):
                    ?>
                        <div class="brand-item">
                            <a href="<?php echo esc_url($brand_link); ?>"<?php echo $target; ?><?php echo $nofollow; ?>>
                                <img src="<?php echo esc_url($brand_img); ?>" alt="Brand Logo">
                            </a>
                        </div>
                    <?php 
                        endif;
                    endforeach; 
                    ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
