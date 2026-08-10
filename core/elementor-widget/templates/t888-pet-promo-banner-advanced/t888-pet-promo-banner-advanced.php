<?php
$bg_color = $bg_color ?? '#8a7ba3';
$top_subtitle = $top_subtitle ?? '';
$title = $title ?? '';
$button_text = $button_text ?? '';
$button_link = $button_link ?? [];
$image_1 = $image_1 ?? [];
$image_2 = $image_2 ?? [];
$icon_class = $icon_class ?? '';

$link_url = !empty($button_link['url']) ? $button_link['url'] : '#';
$link_target = !empty($button_link['is_external']) ? ' target="_blank"' : '';
$link_rel = !empty($button_link['nofollow']) ? ' rel="nofollow"' : '';

$img1_url = !empty($image_1['url']) ? $image_1['url'] : '';
$img2_url = !empty($image_2['url']) ? $image_2['url'] : '';
?>

<div class="t888-pet-promo-banner-advanced" style="background-color: <?php echo esc_attr($bg_color); ?>;">
    <div class="promo-content">
        <?php if ($top_subtitle): ?>
            <h5 class="promo-subtitle">
                <?php echo wp_kses_post($top_subtitle); ?>
            </h5>
        <?php endif; ?>

        <?php if ($title): ?>
            <p class="promo-title">
                <?php echo wp_kses_post($title); ?>
            </p>
        <?php endif; ?>

        <?php if ($button_text): ?>
            <div class="promo-button-wrap">
                <a href="<?php echo esc_url($link_url); ?>"<?php echo $link_target; ?><?php echo $link_rel; ?> class="promo-button">
                    <?php echo esc_html($button_text); ?>
                </a>
            </div>
        <?php endif; ?>
    </div>

    <?php if ($img1_url): ?>
        <div class="promo-img promo-img-1">
            <img src="<?php echo esc_url($img1_url); ?>" alt="<?php echo esc_attr(strip_tags($top_subtitle)); ?>">
        </div>
    <?php endif; ?>

    <?php if ($img2_url): ?>
        <div class="promo-img promo-img-2">
            <img src="<?php echo esc_url($img2_url); ?>" alt="<?php echo esc_attr(strip_tags($title)); ?>">
        </div>
    <?php endif; ?>

    <?php if ($icon_class): ?>
        <i class="promo-icon <?php echo esc_attr($icon_class); ?>"></i>
    <?php endif; ?>
</div>
