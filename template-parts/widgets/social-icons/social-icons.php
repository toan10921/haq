<?php
if (isset($data['icons']) && is_array($data['icons'])) {
    $icons = $data['icons'];
} else {
    $icons = array();
}

$title = isset($data['title']) ? $data['title'] : '';
?>

<div class="widget widget-social-icons">
    <?php if (!empty($title)) : ?>
        <h5 class="widget-title title"><?php echo esc_html($title); ?></h5>
    <?php endif; ?>
<div class="list-icons">
    <?php foreach ($icons as $key => $icon) : ?>
        <?php if (!empty($icon['icon'])) : ?>
            <?php
            $icon_url = get_template_directory_uri() . '/assets/images/' . esc_attr($icon['icon']);
            ?>
            <a href="<?php echo !empty($icon['link']) ? esc_url($icon['link']) : ''; ?>" target="_blank" class="social-icon">
                <i class="<?php echo esc_attr($icon['icon']); ?>"></i>
            </a>
        <?php endif; ?>
    <?php endforeach; ?>
    </div>
</div>
