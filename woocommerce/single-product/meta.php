<?php

/**
 * Single Product Meta
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/meta.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     9.7.0
 */

if (! defined('ABSPATH')) {
	exit;
}

global $product;
?>
<div class="product_meta product-detail__meta">
	<?php do_action('woocommerce_product_meta_start'); ?>

	<?php if (wc_product_sku_enabled() && ($product->get_sku() || $product->is_type('variable'))) : ?>
		<div class="meta_row">
			<span class="meta_label"><?php esc_html_e('SKU:', 'nebon'); ?></span>
			<span class="meta_value">
				<?php echo esc_html($product->get_sku() ?: __('N/A', 'nebon')); ?>
			</span>
		</div>
	<?php endif; ?>


	<?php
	$categories_list = wc_get_product_category_list(
		$product->get_id(),
		', ',
		'',
		''
	);
	$categories_list = str_replace(
		',',
		'<span style="color: var(--primary-color); font-weight: 400">,</span>',
		$categories_list
	);
	?>
	<div class="meta_row">
		<span class="meta_label"><?php esc_html_e('Categories:', 'nebon'); ?></span>
		<span class="meta_value"><?php echo wp_kses_post($categories_list); ?></span>
	</div>

	<?php
	$tags_list = wc_get_product_tag_list(
		$product->get_id(),
		', ',
		'',
		''
	);
	$tags_list = str_replace(
		',',
		'<span style="color: var(--primary-color); font-weight: 400">,</span>',
		$tags_list
	);
	?>
	<div class="meta_row">
		<span class="meta_label"><?php esc_html_e('Tags:', 'nebon'); ?></span>
		<span class="meta_value"><?php echo wp_kses_post($tags_list); ?></span>
	</div>
	<?php
	$brands = wp_get_post_terms($product->get_id(), 'product_brand');
	if (!empty($brands) && !is_wp_error($brands)) :
	?>
		<div class="meta_row">
			<span class="meta_label"><?php esc_html_e('Brand:', 'nebon'); ?></span>
			<span class="meta_value">
				<?php foreach ($brands as $brand) : ?>
					<a href="<?php echo esc_url(get_term_link($brand)); ?>">
						<?php echo esc_html($brand->name); ?>
					</a>
				<?php endforeach; ?>
			</span>
		</div>
	<?php endif; ?>

	<?php do_action('woocommerce_product_meta_end'); ?>
</div>
