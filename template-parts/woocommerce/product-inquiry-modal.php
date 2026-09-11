<?php
$inquiry_popup_id = !empty($inquiry_popup_id)
    ? sanitize_html_class($inquiry_popup_id)
    : 't888-global-inquiry-modal';
$contact_form_html = is_string($contact_form_html ?? null) ? $contact_form_html : '';
?>
<div
    class="t888-product-inquiry-modal t888-product-inquiry-modal--style6"
    id="<?php echo esc_attr($inquiry_popup_id); ?>"
    hidden
    aria-hidden="true"
>
    <section
        class="t888-product-inquiry-modal__dialog"
        role="dialog"
        aria-modal="true"
        aria-labelledby="<?php echo esc_attr($inquiry_popup_id); ?>-title"
        aria-describedby="<?php echo esc_attr($inquiry_popup_id); ?>-product"
    >
        <header class="t888-product-inquiry-modal__header">
            <h2 id="<?php echo esc_attr($inquiry_popup_id); ?>-title">
                <span aria-hidden="true"></span>
                <?php esc_html_e('Yêu Cầu Báo Giá & Tư Vấn Kỹ Thuật', 'nebon'); ?>
            </h2>
            <button
                class="t888-product-inquiry-modal__close"
                type="button"
                aria-label="<?php esc_attr_e('Đóng cửa sổ', 'nebon'); ?>"
            >
                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="m6 6 12 12M18 6 6 18"/></svg>
            </button>
        </header>

        <div class="t888-product-inquiry-modal__product">
            <span class="t888-product-inquiry-modal__info" aria-hidden="true">i</span>
            <div>
                <span><?php esc_html_e('Sản phẩm quan tâm:', 'nebon'); ?></span>
                <strong id="<?php echo esc_attr($inquiry_popup_id); ?>-product"></strong>
            </div>
        </div>

        <div class="t888-product-inquiry-form">
            <?php if ($contact_form_html !== ''): ?>
                <?php echo $contact_form_html; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
            <?php else: ?>
                <p class="t888-product-inquiry-form__notice">
                    <?php esc_html_e('Chưa tìm thấy Contact Form 7. Hãy cài plugin và tạo ít nhất một biểu mẫu liên hệ.', 'nebon'); ?>
                </p>
            <?php endif; ?>

            <p class="t888-product-inquiry-form__hotline">
                <?php esc_html_e('Hoặc liên hệ hotline:', 'nebon'); ?>
                <a href="tel:0969325914">0969.325.914 (Zalo 24/7)</a>
            </p>
        </div>
    </section>
</div>
