<div class="product-price">
    <?php
    if ($product->is_type('grouped')) {
        $child_products = $product->get_children();
        $prices = [];
        foreach ($child_products as $child_id) {
            $child_product = wc_get_product($child_id);
            if ($child_product) {
                $prices[] = floatval($child_product->get_price());
            }
        }
        if (!empty($prices)) {
            $min_price = min($prices);
            $max_price = max($prices);

            if ($min_price == $max_price) {
                $display_price = wc_price($min_price);
            } else {
                $display_price = wc_price($min_price) . ' - ' . wc_price($max_price);
            }
        } else {
            $display_price = __('Contact for price', 'nebon');
        }

        echo '<span class="grouped-product-price">' . $display_price . '</span>';
    } elseif ($product->is_type('variable')) {
        $available_variations = $product->get_available_variations();
        $variation_prices = [];

        foreach ($available_variations as $variation) {
            $variation_obj = wc_get_product($variation['variation_id']);
            if ($variation_obj && $variation_obj->get_price() !== '') {
                $variation_prices[] = floatval($variation_obj->get_price());
            }
        }

        if (!empty($variation_prices)) {
            $min_price = min($variation_prices);
            $max_price = max($variation_prices);

            if ($min_price == $max_price) {
                echo '<span class="variable-product-price">' . wc_price($min_price) . '</span>';
            } else {
                echo '<span class="variable-product-price">' . wc_price($min_price) . ' - ' . wc_price($max_price) . '</span>';
            }
        } else {
            echo '<span class="contact-price">' . esc_html__('Contact', 'nebon') . '</span>';
        }
    } else {
        if ($has_price):
            if ($product->is_on_sale()):
    ?>
                <span class="regular-price" style="text-decoration: line-through; opacity: 0.6;">
                    <?php echo wc_price($product->get_regular_price()); ?>
                </span>
                <span class="sale-price"><?php echo wc_price($product->get_sale_price()); ?></span>
            <?php
            else:
                echo wc_price($product_price);
            endif;
        else:
            ?>
            <span class="contact-price"><?php esc_html_e('Contact', 'nebon'); ?></span>
    <?php endif;
    }
    ?>
</div>