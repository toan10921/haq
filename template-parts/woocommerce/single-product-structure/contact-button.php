<?php
defined('ABSPATH') || exit;

$product = isset($product) && $product instanceof WC_Product
    ? $product
    : wc_get_product(get_queried_object_id());

if (!$product) {
    return;
}

$product_name = $product->get_name();
$product_url = $product->get_permalink();
?>

<div class="t888-single-product-contact-wrap">
    <button
        type="button"
        class="t888-single-product-contact t888-inquiry-trigger"
        data-product-name="<?php echo esc_attr($product_name); ?>"
        data-product-url="<?php echo esc_url($product_url); ?>"
        aria-haspopup="dialog"
        aria-controls="t888-global-inquiry-modal"
        aria-label="<?php echo esc_attr(sprintf(__('Liên hệ về %s', 'nebon'), $product_name)); ?>"
    >
        <span class="t888-single-product-contact__text"><?php esc_html_e('Liên hệ', 'nebon'); ?></span>
        <span class="t888-single-product-contact__icon" aria-hidden="true">
            <svg viewBox="0 0 24 24"><path d="M7 17 17 7M10 7h7v7"/></svg>
        </span>
    </button>
</div>
