<?php

/**
 * Simple product add to cart
 *
 * @package WooCommerce\Templates
 * @version 7.0.1
 */

defined('ABSPATH') || exit;

global $product;

if (! $product->is_purchasable()) {
	return;
}

// echo wc_get_stock_html($product); 

if ($product->is_in_stock()) :
	do_action('woocommerce_before_add_to_cart_form');
?>

	<form class="cart grouped_form simple-form" action="<?php echo esc_url(apply_filters('woocommerce_add_to_cart_form_action', $product->get_permalink())); ?>" method="post" enctype='multipart/form-data'>
		<table cellspacing="0" class="woocommerce-grouped-product-list group_table">
			<tbody>
				<tr id="product-<?php echo esc_attr($product->get_id()); ?>" class="woocommerce-grouped-product-list-item <?php echo esc_attr(implode(' ', wc_get_product_class('', $product))); ?>">
					<td class="woocommerce-grouped-product-list-item__thumbnail">
						<a href="<?php echo esc_url($product->get_permalink()); ?>">
							<?php
							if (has_post_thumbnail($product->get_id())) {
								echo get_the_post_thumbnail($product->get_id(), 'shop_thumbnail', array('alt' => $product->get_name()));
							} else {
								echo '<img src="' . esc_url(get_template_directory_uri() . '/assets/images/100x150.png') . '" alt="'.esc_attr($product->get_name()).'">';
							}
							?>
						</a>
					</td>

					<td class="woocommerce-grouped-product-list-item__label_price">
						<div class="product-label-price-sold">
							<label for="product-<?php echo esc_attr($product->get_id()); ?>">
								<?php echo esc_html($product->get_name()); ?>
							</label>
							<div class="product-price">
								<?php echo wp_kses_post($product->get_price_html()); ?>
								<?php echo wc_get_stock_html($product); ?>
							</div>

							<?php
							$stock_quantity = $product->get_stock_quantity();
							$sold_quantity  = get_post_meta($product->get_id(), 'total_sales', true);

							$sold_quantity = (!empty($sold_quantity)) ? (int)$sold_quantity : 0;
							$stock_quantity = (!empty($stock_quantity)) ? (int)$stock_quantity : 0;
							$total_quantity = $sold_quantity + $stock_quantity;
							$percentage_sold = ($total_quantity > 0) ? ($sold_quantity / $total_quantity) * 100 : 0;
							?>

							<div class="product-progress-bar">
								<div class="progress">
									<div class="progress-fill" style="width:<?php echo esc_attr($percentage_sold); ?>%;"></div>
								</div>
								<div class="progress-text">
									<div class="progress-sold">
										<span class="label"><?php esc_html_e('Sold:', 'nebon'); ?></span>
										<span class="quantity"><?php echo esc_html($sold_quantity); ?></span>
									</div>
									<div class="progress-available">
										<span class="label"><?php esc_html_e('Available:', 'nebon'); ?></span>
										<span class="quantity"><?php echo esc_html($stock_quantity); ?></span>
									</div>
								</div>
							</div>
						</div>
					</td>

					<td class="woocommerce-grouped-product-list-item__quantity">
						<?php
						do_action('woocommerce_before_add_to_cart_quantity');
						woocommerce_quantity_input(array(
							'min_value'   => apply_filters('woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product),
							'max_value'   => apply_filters('woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product),
							'input_value' => isset($_POST['quantity']) ? wc_stock_amount(wp_unslash($_POST['quantity'])) : $product->get_min_purchase_quantity(),
						));
						do_action('woocommerce_after_add_to_cart_quantity');
						?>
					</td>
				</tr>
			</tbody>
		</table>

		<input type="hidden" name="add-to-cart" value="<?php echo esc_attr($product->get_id()); ?>" />

		<div class="grouped-product-actions product-detail__purchase">
			<div class="action1 product-detail__purchase-row">
				<div class="woocommerce-grouped-product-list-item__quantity product-detail__quantity">
					<?php
					do_action('woocommerce_before_add_to_cart_quantity');
					woocommerce_quantity_input(array(
						'min_value'   => apply_filters('woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product),
						'max_value'   => apply_filters('woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product),
						'input_value' => isset($_POST['quantity']) ? wc_stock_amount(wp_unslash($_POST['quantity'])) : $product->get_min_purchase_quantity(),
					));
					do_action('woocommerce_after_add_to_cart_quantity');
					?>
				</div>
				<button type="submit" class="single_add_to_cart_button product-detail__purchase-button button alt<?php echo esc_attr(wc_wp_theme_get_element_class_name('button') ? ' ' . wc_wp_theme_get_element_class_name('button') : ''); ?>">
					<?php echo esc_html($product->single_add_to_cart_text()); ?>
				</button>


				<?php do_action('t888f_custom_add_wishlist_compare_buttons'); ?>
			</div>
			<?php
			t888f_get_template('woocommerce/single-product-structure/user-action', '', array(), true);
			?>
		</div>

	</form>

	<?php do_action('woocommerce_after_add_to_cart_form'); ?>

<?php endif; ?>
