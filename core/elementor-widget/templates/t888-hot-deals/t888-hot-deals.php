<?php
$product_ids_raw = is_array($sale_products ?? null) ? $sale_products : [];
$product_ids = array_filter(array_map('intval', $product_ids_raw));

$columns = $columns ?? '4';
$link_button = $link_button ?? false;
$button_text = $button_text ?? __('Shop all ', 'nebon');
$infinitive_sale = $infinitive_sale ?? false;
?>

<div class="t888-hot-deals-grid columns-<?php echo esc_attr($columns); ?>">
    <?php foreach ($product_ids as $product_id): ?>
        <?php
        $product = wc_get_product($product_id);
        if (!$product || !$product->is_visible()) continue;

        $sale_start = (int) get_post_meta($product_id, '_sale_price_dates_from', true);
        $sale_end = (int) get_post_meta($product_id, '_sale_price_dates_to', true);
        $now = time();


        if ($infinitive_sale === 'yes' && $sale_end < $now) {
            $sale_start = $now;
            $sale_end = $now + (10 * DAY_IN_SECONDS);
        }
        ?>
        <div class="product-item">
            <?php
            t888f_get_template('woocommerce/loop/grid/grid-hotdeals', '', [
                'product'     => $product,
                'size'        => get_theme_mod('show_single_size_extra_display', 'woocommerce_thumbnail'),
                'style'       => get_theme_mod('single_item_style_extra_display', 'default'),
                'sale_from'   => $sale_start,
                'sale_to'     => $sale_end,
            ], true);
            ?>
        </div>
    <?php endforeach; ?>
</div>

<?php if ($button_text): ?>
    <div class="d-flex justify-content-center">
        <button class="hotdeal-button button">
            <?php if ($link_button && !empty($link_button['url'])): ?>
                <a href="<?php echo esc_url($link_button['url']); ?>" target="<?php echo esc_attr($link_button['is_external'] ? '_blank' : '_self'); ?>" rel="<?php echo esc_attr($link_button['nofollow'] ? 'nofollow' : ''); ?>">
                    <?php echo esc_html($button_text); ?>
                </a>
            <?php else: ?>
                <?php echo esc_html($button_text); ?>
            <?php endif; ?>
        </button>
    </div>
<?php endif; ?>
