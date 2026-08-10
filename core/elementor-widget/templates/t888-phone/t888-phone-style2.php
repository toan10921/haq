<?php
if (!defined('ABSPATH')) {
    exit;
}

$icon = $icon ?? '';
$number = $number ?? '';
?>

<div class="t888-phone-widget style2 d-flex align-items-end">
    <?php if (!empty($icon)) : ?>
        <span class="phone-icon">
            <?php \Elementor\Icons_Manager::render_icon($icon, ['aria-hidden' => 'true']); ?>
        </span>
    <?php endif; ?>

    <div class="phone-info">
        <?php if (!empty($number)) : ?>
            <div class="phone-number"><a href="tel:<?php echo esc_attr(preg_replace('/\D+/', '', $number)); ?>"><?php echo esc_html($number); ?></a></div>
        <?php endif; ?>
    </div>
</div>
