<?php
$bg_image = $bg_image ?? [];
$right_image = $right_image ?? [];
$bg_color = $bg_color ?? '#563e8c';
$text_color = $text_color ?? '#ffffff';
$button_bg_color = $button_bg_color ?? '#ffffff';
$button_text_color = $button_text_color ?? '#000000';
$layout_style = $layout_style ?? 'style1';

$discount = $discount ?? '';
$subtitle = $subtitle ?? '';
$top_label = $top_label ?? '';
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
    $btn_css .= 'background-color: ' . esc_attr($button_bg_color) . '; border-color: ' . esc_attr($button_bg_color) . '; ';
} else {
    $btn_css .= 'background-color: transparent; border-color: #fff; ';
}
if ($button_text_color) {
    $btn_css .= 'color: ' . esc_attr($button_text_color) . '; ';
}
?>

<div class="t888-pet-sale-banner" style="background-color: <?php echo esc_attr($bg_color); ?>; <?php echo $bg_style; ?>;">
    
    <div class="t888-pet-sale-banner__content">
        <?php if ($layout_style === 'style1') : ?>
            
            <?php if ($discount): ?>
                <div class="t888-pet-sale-banner__discount" style="color: <?php echo esc_attr($text_color); ?>;">
                    <?php echo wp_kses_post($discount); ?>
                </div>
            <?php endif; ?>

            <?php if ($subtitle): ?>
                <div class="t888-pet-sale-banner__subtitle" style="color: <?php echo esc_attr($text_color); ?>;">
                    <?php echo wp_kses_post($subtitle); ?>
                </div>
            <?php endif; ?>

            <?php if ($top_label): ?>
                <div class="t888-pet-sale-banner__top-label" style="color: <?php echo esc_attr($text_color); ?>;">
                    <?php echo wp_kses_post($top_label); ?>
                </div>
            <?php endif; ?>

        <?php else : ?>
            
            <?php if ($subtitle): ?>
                <div class="t888-pet-sale-banner__subtitle" style="color: <?php echo esc_attr($text_color); ?>;">
                    <?php echo wp_kses_post($subtitle); ?>
                </div>
            <?php endif; ?>

            <?php if ($top_label): ?>
                <div class="t888-pet-sale-banner__top-label" style="color: <?php echo esc_attr($text_color); ?>;">
                    <?php echo wp_kses_post($top_label); ?>
                </div>
            <?php endif; ?>

            <?php if ($discount): ?>
                <div class="t888-pet-sale-banner__discount" style="color: <?php echo esc_attr($text_color); ?>;">
                    <?php echo wp_kses_post($discount); ?>
                </div>
            <?php endif; ?>

        <?php endif; ?>

        <?php if ($button_text): ?>
            <div class="t888-pet-sale-banner__btn-wrap">
                <a href="<?php echo esc_url($link_url); ?>"<?php echo $link_target; ?><?php echo $link_rel; ?> class="t888-pet-sale-banner__btn" style="<?php echo $btn_css; ?>">
                    <?php echo esc_html($button_text); ?>
                </a>
            </div>
        <?php endif; ?>
    </div>

    <?php if ($right_img_url): ?>
        <div class="t888-pet-sale-banner__image">
            <img src="<?php echo esc_url($right_img_url); ?>" alt="<?php echo esc_attr(strip_tags($subtitle)); ?>">
        </div>
    <?php endif; ?>

</div>
