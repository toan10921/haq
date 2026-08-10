<?php

/**
 * Mini-cart
 *
 * Contains the markup for the mini-cart, used by the cart widget.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/mini-cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 10.0.0
 */

defined('ABSPATH') || exit;

do_action('woocommerce_before_mini_cart'); ?>

<?php if (WC()->cart && ! WC()->cart->is_empty()) :
	$cart_item_count = WC()->cart->get_cart_contents_count();
	$cart_products_count = count(WC()->cart->get_cart());
?>
	<input type="hidden" class="cart-item-count" value="<?php echo esc_attr($cart_item_count); ?>">
	<input type="hidden" class="cart-products-count" value="<?php echo esc_attr($cart_products_count); ?>">
	<ul class="woocommerce-mini-cart cart_list product_list_widget <?php echo esc_attr($args['list_class']); ?>">
		<?php
		foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
			$_product   = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
			$product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);

			if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_widget_cart_item_visible', true, $cart_item, $cart_item_key)) {
				/**
				 * This filter is documented in woocommerce/templates/cart/cart.php.
				 *
				 * @since 2.1.0
				 */
				$product_name      = apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key);
				// $thumbnail         = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key);
				if (!has_post_thumbnail($product_id)) {
					$image_url = get_template_directory_uri() . '/assets/images/328x480.png';
					$thumbnail = apply_filters('woocommerce_cart_item_thumbnail', '<img src="' . esc_url($image_url) . '" alt="' . esc_attr($product_name) . '" />', $cart_item, $cart_item_key);
				} else {
					// $thumbnail = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image('woocommerce_thumbnail'), $cart_item, $cart_item_key);
					// get product thumbnail id
					$thumbnail_id = get_post_thumbnail_id($product_id);
					$thumbnail = apply_filters('woocommerce_cart_item_thumbnail', wp_get_attachment_image($thumbnail_id, 'product-list-default'), $cart_item, $cart_item_key);
				}
				$product_price     = apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key);
				$product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($cart_item) : '', $cart_item, $cart_item_key);
		?>
				<li class="woocommerce-mini-cart-item <?php echo esc_attr(apply_filters('woocommerce_mini_cart_item_class', 'mini_cart_item', $cart_item, $cart_item_key)); ?>" data-cart_item_key="<?php echo esc_attr($cart_item_key); ?>">
					<div class="product-cart-item-thumbnail">
						<?php if (empty($product_permalink)) : ?>
							<?php echo wp_kses_post($thumbnail);  else : ?>
							<a href="<?php echo esc_url($product_permalink); ?>">
								<?php echo wp_kses_post($thumbnail); ?>
							</a>
						<?php endif; ?>
					</div>
					<div class="product-cart-item-content">
						<h6 class="m-0 mini-cart-item-title font-poppins  text-uppercase">
							<?php if (empty($product_permalink)) : ?>
								<?php echo wp_kses_post($product_name); ?>
							<?php else : ?>
								<a class="font-poppins fw-normal text-uppercase" href="<?php echo esc_url($product_permalink); ?>">
									<?php echo wp_kses_post($product_name); ?>
								</a>
							<?php endif; ?>
						</h6>
						<?php echo wc_get_formatted_cart_item_data($cart_item); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
						?>
						<!-- quantity -->
						<div class="mini-cart-item-quantity position-relative">
							<button type="button" class="minus">-</button>
							<input type="number" id="quantity_<?php echo esc_attr($cart_item_key); ?>" class="input-text qty text" step="1" min="1" max="" name="quantity" value="<?php echo esc_attr($cart_item['quantity']); ?>" title="Qty" size="4" inputmode="numeric">
							<button type="button" class="plus">+</button>
						</div>
						<?php echo apply_filters('woocommerce_widget_cart_item_quantity', '<span class="quantity">' . sprintf('%s &times; %s', $cart_item['quantity'], $product_price) . '</span>', $cart_item, $cart_item_key); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
						?>
						<a href="#" data-cart_item_key="<?php echo esc_attr($cart_item_key); ?>" type="button" class="remove-cart-item"><i class="la la-times"></i></a>
					</div>
				</li>
		<?php
			}
		}

		do_action('woocommerce_mini_cart_contents');
		?>
	</ul>
	<div class="mini-cart-total-button-wrap">
		<p class="woocommerce-mini-cart__total total">
			<?php
			/**
			 * Hook: woocommerce_widget_shopping_cart_total.
			 *
			 * @hooked woocommerce_widget_shopping_cart_subtotal - 10
			 */
			do_action('woocommerce_widget_shopping_cart_total');
			?>
		</p>
		<?php
		// === Free shipping progress bar ===
		$rule = function_exists('t888_get_free_shipping_rule_for_current_zone') ? t888_get_free_shipping_rule_for_current_zone() : null;

		if ($rule && WC()->cart) {
			$min  = (float) $rule['min_amount'];
			$curr = t888_get_cart_amount_for_free_shipping_check((bool) $rule['ignore_discounts']);

			$left = max(0, $min - $curr);
			$pct  = $min > 0 ? max(0, min(100, round(($curr / $min) * 100))) : 0;

			if ($left > 0) {
				$msg = sprintf(
					__('Add %s to cart and get free shipping!', 'nebon'),
					'<span>' . wc_price($min) . '</span>'
				);
				$msg_html = wp_kses($msg, ['span' => ['class' => true], 'bdi' => [], 'strong' => []]);
			} else {
				$msg_html = esc_html__('Your order qualifies for free shipping!', 'nebon');
				$pct = 100;
			}
		?>
			<div class="t888-free-ship-box">
				<div class="t888-free-ship-msg"><?php echo wp_kses_post($msg_html); ?></div>
				<div class="t888-free-ship-progress" aria-label="<?php echo esc_attr($pct . '%'); ?>">
					<span class="t888-free-ship-bar" style="width: <?php echo esc_attr($pct); ?>%;"></span>
				</div>
			</div>
		<?php
		}
		// === /Free shipping progress bar ===
		?>


		<?php do_action('woocommerce_widget_shopping_cart_before_buttons'); ?>

		<p class="woocommerce-mini-cart__buttons buttons"><?php do_action('woocommerce_widget_shopping_cart_buttons'); ?></p>

		<?php do_action('woocommerce_widget_shopping_cart_after_buttons'); ?>
	</div>

<?php else : ?>

	<p class="woocommerce-mini-cart__empty-message"><?php esc_html_e('No products in the cart.', 'nebon'); ?></p>

<?php endif; ?>

<?php do_action('woocommerce_after_mini_cart'); ?>