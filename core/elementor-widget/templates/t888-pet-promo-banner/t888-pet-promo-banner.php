<?php
$bg_image = $bg_image ?? [];
$right_image = $right_image ?? [];
$bg_color = $bg_color ?? '#a18374';
$text_color = $text_color ?? '#ffffff';
$button_bg_color = $button_bg_color ?? '#ffffff';
$button_text_color = $button_text_color ?? '#000000';
$top_subtitle = $top_subtitle ?? '';
$title = $title ?? '';
$big_text = $big_text ?? '';
$button_text = $button_text ?? '';
$button_link = $button_link ?? [];

$bg_url = !empty($bg_image['url']) ? $bg_image['url'] : '';
$right_img_url = !empty($right_image['url']) ? $right_image['url'] : '';
$bg_style = $bg_url ? "background-image: url('" . esc_url($bg_url) . "'); background-size: cover; background-position: center;" : '';
$link_url = !empty($button_link['url']) ? $button_link['url'] : '#';
$link_target = !empty($button_link['is_external']) ? ' target="_blank"' : '';
$link_rel = !empty($button_link['nofollow']) ? ' rel="nofollow"' : '';

$btn_css = '';
if ($button_bg_color && $button_bg_color !== 'rgba(0,0,0,0)' && $button_bg_color !== 'transparent') {
    $btn_css .= 'background-color: ' . esc_attr($button_bg_color) . '; ';
} else {
    $btn_css .= 'background-color: transparent; padding: 0; ';
}
if ($button_text_color) {
    $btn_css .= 'color: ' . esc_attr($button_text_color) . '; ';
}
?>

<div class="t888-pet-promo-banner" style="background-color: <?php echo esc_attr($bg_color); ?>; <?php echo $bg_style; ?>;">
    
    <div class="promo-content">
        <?php if ($top_subtitle): ?>
            <h5 class="promo-subtitle" style="color: <?php echo esc_attr($text_color); ?>;">
                <?php echo wp_kses_post($top_subtitle); ?>
            </h5>
        <?php endif; ?>

        <?php if ($title): ?>
            <p class="promo-title" style="color: <?php echo esc_attr($text_color); ?>;">
                <?php echo wp_kses_post($title); ?>
            </p>
        <?php endif; ?>

        <?php if ($big_text): ?>
            <h2 class="promo-big-text" style="color: <?php echo esc_attr($text_color); ?>;">
                <?php echo wp_kses_post(nl2br($big_text)); ?>
            </h2>
        <?php endif; ?>

        <?php if ($button_text): ?>
            <div class="promo-button-wrap">
                <a href="<?php echo esc_url($link_url); ?>"<?php echo $link_target; ?><?php echo $link_rel; ?> class="promo-button" style="<?php echo $btn_css; ?>">
                    <?php echo esc_html($button_text); ?>
                </a>
            </div>
        <?php endif; ?>
    </div>

    <?php if ($right_img_url): ?>
        <div class="promo-right-image">
            <img src="<?php echo esc_url($right_img_url); ?>" alt="<?php echo esc_attr(strip_tags($top_subtitle)); ?>">
        </div>
    <?php endif; ?>

</div>
