<?php
/**
 * Template for Footer Social & Payment Widget
 */
// Extracted from control IDs
$title_social = isset($social_title) ? $social_title : 'FOLLOW US:';
$social_list = isset($social_items) ? $social_items : [];
$title_payment = isset($payment_title) ? $payment_title : 'PAYMENT METHODS:';
$payment_url = (!empty($payment_image) && !empty($payment_image['url'])) ? $payment_image['url'] : '';
?>

<div class="footer-social-payment">
    <div class="social-section">
        <?php if (!empty($title_social)): ?>
            <h5 class="social-title"><?php echo esc_html($title_social); ?></h5>
        <?php
endif; ?>

        <div class="social-icons">
            <?php
if (!empty($social_list)):
    foreach ($social_list as $item):
?>
                <?php if (!empty($item['social_icon']['value'])): ?>
                    <a href="<?php echo esc_url(isset($item['social_link']['url']) ? $item['social_link']['url'] : '#'); ?>" target="_blank" class="social-link">
                        <?php
            \Elementor\Icons_Manager::render_icon($item['social_icon'], ['aria-hidden' => 'true']);
?>
                    </a>
                <?php
        endif; ?>
            <?php
    endforeach;
endif;
?>
        </div>
    </div>

    <div class="footer-separator"></div>

    <div class="payment-section">
        <?php if (!empty($title_payment)): ?>
            <h5 class="payment-title"><?php echo esc_html($title_payment); ?></h5>
        <?php
endif; ?>

        <div class="payment-icons">
            <?php if ($payment_url): ?>
                <img src="<?php echo esc_url($payment_url); ?>" alt="Payment Methods">
            <?php
else: ?>
                <div class="payment-fallback">
                    <i class="fab fa-cc-visa"></i>
                    <i class="fab fa-cc-mastercard"></i>
                    <i class="fab fa-cc-amex"></i>
                    <i class="fab fa-cc-paypal"></i>
                    <i class="fab fa-cc-stripe"></i>
                </div>
            <?php
endif; ?>
        </div>
    </div>
</div>
