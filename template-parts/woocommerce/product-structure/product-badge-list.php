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

    if ($regular_price > 0 && $sale_price > 0) {
        $discount = round(100 - ($sale_price / $regular_price) * 100);
    } else {
        $discount = 0;
    }
?>
    <span class="product-badge sale">-<?php echo esc_html($discount); ?><?php echo esc_html__('%', 'nebon'); ?></span>
<?php endif; ?>