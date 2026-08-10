<?php
if (!defined('ABSPATH')) {
    exit;
}

$title    = $title ?? 'FAQS';
$html_tag = $html_tag ?? 'h2';
$icon     = $icon ?? null;
$link     = $link ?? '#';
?>

<div class="t888-heading">
    <span class="line"></span>

    <div class="title-wrapper">
        <?php if (!empty($icon['value'])) : ?>
            <i class="<?php echo esc_attr($icon['value']); ?> bg-icon"></i>
        <?php endif; ?>

        <<?php echo esc_attr($html_tag); ?> class="title">
            <?php echo esc_html($title); ?>
        </<?php echo esc_attr($html_tag); ?>>
    </div>

    <span class="line"></span>
</div>
