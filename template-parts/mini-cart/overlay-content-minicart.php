<div id="t888-minicart-panel" class="t888-minicart-root" aria-hidden="true">
        <div class="mini-cart-overlay"></div>
        <div class="mini-cart-content">
            <div class="mini-cart-heading d-flex align-items-center justify-content-between">
                <h5 class="fw-bold text-uppercase m-0 position-relative">
                    <?php echo esc_html__('Shopping Cart', 'nebon'); ?>
                </h5>
                <div class="btn-close-mini-cart">
                    <a href="#" rel="nofollow" class="d-flex align-items-center">
                        <i class="la la-times title18"></i> 
                        <span><?php echo esc_html__('Close', 'nebon'); ?></span>
                    </a>
                </div>
            </div>

            <div class="mini-cart-main-body">
                <div class="mini-cart-main-content 
                    <?php echo (WC()->cart == null || WC()->cart->is_empty()) ? 'empty-cart' : ''; ?>">
                    <?php if (WC()->cart == null || WC()->cart->is_empty()) : ?>
                        <div class="mini-cart-empty">
                            <?php echo esc_html__('No products in the cart.', 'nebon'); ?>
                        </div>
                    <?php else: ?>
                        <ul class="woocommerce-mini-cart cart_list product_list_widget">
                            <?php foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item): 
                                $_product   = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
                                $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);
                                if (!$_product || !$_product->exists() || $cart_item['quantity'] <= 0) continue;
                                $product_name = $_product->get_name();
                                $thumbnail    = $_product->get_image();
                                $product_price = WC()->cart->get_product_price($_product);
                            ?>
                                <li class="woocommerce-mini-cart-item d-flex align-items-center">
                                    <div class="product-thumbnail"><?php echo $thumbnail; ?></div>
                                    <div class="product-info">
                                        <a href="<?php echo esc_url($_product->get_permalink($cart_item)); ?>">
                                            <?php echo esc_html($product_name); ?>
                                        </a>
                                        <span class="quantity">
                                            <?php echo sprintf('%s × %s', esc_html($cart_item['quantity']), $product_price); ?>
                                        </span>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                        <p class="woocommerce-mini-cart__total total mt-3 d-flex justify-content-between">
                            <strong><?php esc_html_e('Subtotal', 'nebon'); ?>:</strong> 
                            <?php wc_cart_totals_subtotal_html(); ?>
                        </p>
                        <p class="woocommerce-mini-cart__buttons buttons">
                            <a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="button wc-forward">
                                <?php esc_html_e('View cart', 'nebon'); ?>
                            </a>
                            <a href="<?php echo esc_url( wc_get_checkout_url() ); ?>" class="button checkout wc-forward">
                                <?php esc_html_e('Checkout', 'nebon'); ?>
                            </a>
                        </p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>