<?php
/**
 * Template for Footer Contact Info Widget
 */
$logo_url = !empty($logo['url']) ? $logo['url'] : '';
$logo_text_val = $logo_text ?? 'NEBON';
$address_val = $address ?? '';
$phone_label_val = $phone_label ?? '';
$email_val = $email ?? '';
$hotline_val = $hotline ?? '';
$app_store_url = !empty($app_store_link['url']) ? $app_store_link['url'] : '#';
$google_play_url = !empty($google_play_link['url']) ? $google_play_link['url'] : '#';
?>

<div class="footer-contact-info">
    <div class="footer-logo">
        <?php if ($logo_url): ?>
            <img src="<?php echo esc_url($logo_url); ?>" alt="<?php echo esc_attr($logo_text_val); ?>">
        <?php
else: ?>
            <h2 class="logo-text"><?php echo esc_html($logo_text_val); ?></h2>
        <?php
endif; ?>
    </div>

    <div class="contact-details">
        <?php if ($address_val): ?>
            <p class="contact-address"><?php echo esc_html($address_val); ?></p>
        <?php
endif; ?>
        
        <?php if ($phone_label_val): ?>
            <p class="contact-phone-label"><?php echo esc_html($phone_label_val); ?></p>
        <?php
endif; ?>

        <?php if ($email_val): ?>
            <p class="contact-email"><?php echo esc_html__('Email: ', 'nebon') . esc_html($email_val); ?></p>
        <?php
endif; ?>
    </div>

    <?php if ($hotline_val): ?>
        <div class="hotline-box">
            <i class="las la-phone-volume"></i>
            <span class="hotline-number"><?php echo esc_html($hotline_val); ?></span>
        </div>
    <?php
endif; ?>

    <div class="app-buttons">
        <a href="<?php echo esc_url($app_store_url); ?>" class="app-btn app-store">
            <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/app-store.png'); ?>" alt="App Store">
        </a>
        <a href="<?php echo esc_url($google_play_url); ?>" class="app-btn google-play">
            <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/google-play.png'); ?>" alt="Google Play">
        </a>
    </div>
</div>
