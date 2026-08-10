<?php
$before_image = $before_image['url'] ?? '';
$after_image = $after_image['url'] ?? '';
$before_label = $before_label ?? 'Before';
$after_label = $after_label ?? 'After';
?>

<div class="t888-image-compare-wrapper">
    <div class="t888-image-compare twentytwenty-container">
        <img src="<?php echo esc_url($before_image); ?>" alt="Before Image">
        <img src="<?php echo esc_url($after_image); ?>" alt="After Image">
        <div class="twenty-before-label"><?php echo esc_html($before_label); ?></div>
        <div class="twenty-after-label"><?php echo esc_html($after_label); ?></div>
    </div>
</div>