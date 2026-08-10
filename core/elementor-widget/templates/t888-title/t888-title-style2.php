<?php
if (!defined('ABSPATH')) {
    exit;
}

$title    = $title ?? 'FAQS';
$html_tag = $html_tag ?? 'h2';
$link     = $link ?? '#';
?>

<div class="t888-heading style2">
    <div class="title-wrapper">
        <<?php echo esc_attr($html_tag); ?> class="title">
            <?php echo esc_html($title); ?>
        </<?php echo esc_attr($html_tag); ?>>
    </div>
</div>
