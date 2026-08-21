<?php
$button_text = isset($style3_button_text) && $style3_button_text !== '' ? $style3_button_text : __('Get In Touch', 'nebon');
$button_url = (isset($button_url) && is_array($button_url)) ? $button_url : [];
$style3_icon = (isset($style3_icon) && is_array($style3_icon)) ? $style3_icon : [];

$url = !empty($button_url['url']) ? $button_url['url'] : '#';
$target = !empty($button_url['is_external']) ? ' target="_blank"' : '';
$rel_values = [];

if (!empty($button_url['nofollow'])) {
    $rel_values[] = 'nofollow';
}
if (!empty($button_url['is_external'])) {
    $rel_values[] = 'noopener noreferrer';
}

$rel = !empty($rel_values) ? ' rel="' . esc_attr(implode(' ', $rel_values)) . '"' : '';
?>
<div class="t888-button-style3-wrap">
    <a class="t888-button button style3" href="<?php echo esc_url($url); ?>" style="display: flex; align-items: center; justify-content: space-around;"<?php echo apply_filters('tech888f_output_content', $target . $rel); ?>>
        <span class="t888-button__text"><?php echo esc_html($button_text); ?></span>
        <?php if (!empty($style3_icon['value'])) : ?>
            <span class="t888-button__icon" aria-hidden="true">
                <?php \Elementor\Icons_Manager::render_icon($style3_icon, ['aria-hidden' => 'true']); ?>
            </span>
        <?php endif; ?>
    </a>
</div>
