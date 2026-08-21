<?php
$icon = $icon ?? [];
$icon_color = $icon_color ?? '#c8605f';
$title = $title ?? 'FREE SHIPPING & RETURN';
$description = $description ?? 'No one rejects, dislikes.';
$hide_divider = $hide_divider ?? '';

$render_uploaded_svg = static function ($icon_settings) {
    if (
        ($icon_settings['library'] ?? '') !== 'svg'
        || empty($icon_settings['value'])
        || !is_array($icon_settings['value'])
    ) {
        return false;
    }

    $attachment_id = absint($icon_settings['value']['id'] ?? 0);
    if (!$attachment_id && !empty($icon_settings['value']['url'])) {
        $attachment_id = attachment_url_to_postid($icon_settings['value']['url']);
    }

    $svg_path = $attachment_id ? get_attached_file($attachment_id) : '';
    if (
        !$svg_path
        || strtolower(pathinfo($svg_path, PATHINFO_EXTENSION)) !== 'svg'
        || !is_readable($svg_path)
    ) {
        return false;
    }

    $svg_markup = file_get_contents($svg_path);
    if ($svg_markup === false) {
        return false;
    }

    $svg_markup = preg_replace('/<\?xml[^>]*\?>/i', '', $svg_markup);
    $svg_markup = preg_replace('/<!DOCTYPE[^>]*(?:\[[\s\S]*?\]\s*)?>/i', '', $svg_markup);

    $svg_attributes = [
        'id' => true,
        'class' => true,
        'xmlns' => true,
        'xmlns:xlink' => true,
        'viewbox' => true,
        'width' => true,
        'height' => true,
        'x' => true,
        'y' => true,
        'x1' => true,
        'x2' => true,
        'y1' => true,
        'y2' => true,
        'cx' => true,
        'cy' => true,
        'r' => true,
        'rx' => true,
        'ry' => true,
        'd' => true,
        'points' => true,
        'fill' => true,
        'fill-rule' => true,
        'clip-rule' => true,
        'stroke' => true,
        'stroke-width' => true,
        'stroke-linecap' => true,
        'stroke-linejoin' => true,
        'stroke-miterlimit' => true,
        'stroke-dasharray' => true,
        'stroke-dashoffset' => true,
        'opacity' => true,
        'transform' => true,
        'preserveaspectratio' => true,
        'aria-hidden' => true,
        'role' => true,
        'focusable' => true,
        'href' => true,
        'xlink:href' => true,
    ];
    $allowed_svg = [
        'svg' => $svg_attributes,
        'g' => $svg_attributes,
        'path' => $svg_attributes,
        'circle' => $svg_attributes,
        'ellipse' => $svg_attributes,
        'rect' => $svg_attributes,
        'line' => $svg_attributes,
        'polyline' => $svg_attributes,
        'polygon' => $svg_attributes,
        'defs' => $svg_attributes,
        'clippath' => $svg_attributes,
        'use' => $svg_attributes,
    ];

    echo wp_kses($svg_markup, $allowed_svg);
    return true;
};

$wrapper_class = 't888-pet-info-box';
if ($hide_divider === 'yes') {
    $wrapper_class .= ' hide-divider';
}
?>

<div class="<?php echo esc_attr($wrapper_class); ?>">
    <div class="info-icon" style="color: <?php echo esc_attr($icon_color); ?>;">
        <?php 
        if (!empty($icon['value'])) {
            if (!$render_uploaded_svg($icon)) {
                \Elementor\Icons_Manager::render_icon($icon, ['aria-hidden' => 'true']);
            }
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
