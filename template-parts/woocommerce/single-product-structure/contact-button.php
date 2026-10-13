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
$phone_display = trim((string) get_theme_mod('product_contact_phone', t888f_get_product_contact_phone_default()));
$phone_href = preg_replace('/[^\d+]/', '', $phone_display);
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
        <span class="t888-single-product-contact__icon" aria-hidden="true">
            <svg viewBox="0 0 24 24"><path d="M7 3h7l5 5v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1z"/><path d="M14 3v5h5"/><path d="M8 13h8M8 17h6"/></svg>
        </span>
        <span class="t888-single-product-contact__text"><?php esc_html_e('Liên hệ', 'nebon'); ?></span>
    </button>
    <?php if ($phone_display !== '' && $phone_href !== '') : ?>
        <a
            class="t888-single-product-phone"
            href="<?php echo esc_url('tel:' . $phone_href); ?>"
            aria-label="<?php echo esc_attr(sprintf(__('Gọi %s', 'nebon'), $phone_display)); ?>"
        >
            <span class="t888-single-product-phone__icon" aria-hidden="true">
                <svg viewBox="0 0 24 24"><path d="M7.2 3.8h2.6l1.3 3.2-1.7 1.1a12.2 12.2 0 0 0 5.5 5.5l1.1-1.7 3.2 1.3v2.6a1.6 1.6 0 0 1-1.7 1.6A14.6 14.6 0 0 1 5.6 5.5a1.6 1.6 0 0 1 1.6-1.7z"/></svg>
            </span>
            <span class="t888-single-product-phone__text"><?php echo esc_html($phone_display); ?></span>
        </a>
    <?php endif; ?>
</div>
