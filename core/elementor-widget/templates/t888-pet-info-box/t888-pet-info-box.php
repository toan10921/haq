<?php
$icon = $icon ?? [];
$icon_color = $icon_color ?? '#c8605f';
$title = $title ?? 'FREE SHIPPING & RETURN';
$description = $description ?? 'No one rejects, dislikes.';
$hide_divider = $hide_divider ?? '';

$wrapper_class = 't888-pet-info-box';
if ($hide_divider === 'yes') {
    $wrapper_class .= ' hide-divider';
}
?>

<div class="<?php echo esc_attr($wrapper_class); ?>">
    <div class="info-icon" style="color: <?php echo esc_attr($icon_color); ?>;">
        <?php 
        if (!empty($icon['value'])) {
            \Elementor\Icons_Manager::render_icon($icon, ['aria-hidden' => 'true']);
        } 
        ?>
    </div>
    <div class="info-content">
        <h4 class="info-title">
            <?php echo wp_kses_post($title); ?>
        </h4>
        <p class="info-desc">
            <?php echo wp_kses_post($description); ?>
        </p>
    </div>
</div>
