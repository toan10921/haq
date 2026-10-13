<?php
/**
 * Single product short description
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/short-description.php.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.3.0
 */

if (!defined('ABSPATH')) {
    exit;
}

global $post;

$short_description = apply_filters('woocommerce_short_description', $post->post_excerpt);

if (!$short_description) {
    return;
}

?>
<div class="t888-short-description is-collapsed">
    <div class="woocommerce-product-details__short-description">
        <?php echo $short_description; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
    </div>
    <button
        type="button"
        class="t888-short-description__more"
        hidden
        aria-expanded="false"
        data-label-more="<?php echo esc_attr__('Xem thêm', 'nebon'); ?>"
        data-label-less="<?php echo esc_attr__('Thu gọn', 'nebon'); ?>"
    >
        <?php esc_html_e('Xem thêm', 'nebon'); ?>
    </button>
</div>
