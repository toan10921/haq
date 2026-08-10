<?php
$background = $background_image['url'] ?? '';
$title_1 = $title_1 ?? '';
$title_2 = $title_2 ?? '';
$button_text = $button_text ?? '';
$video_type = $video_type ?? 'url';
$video_url = $video_url['url'] ?? '';
$video_file = $video_file['url'] ?? '';

$video_link = $video_type === 'file' ? $video_file : $video_url;
?>

<div class="t888-about-wrapper" style="background-image: url('<?php echo esc_url($background); ?>')">
    <div class="t888-about-container">
        <div class="t888-about-box anim-zoom-out">
            <?php if (!empty($title_1)) : ?>
                <span class="t888-about-title"><?php echo esc_html($title_1); ?></span>
            <?php endif; ?>

            <?php if (!empty($title_2)) : ?>
                <span class="t888-about-sub"><?php echo nl2br(esc_html($title_2)); ?></span>
            <?php endif; ?>

            <?php if (!empty($video_link)) : ?>
                <a href="<?php echo esc_url($video_link); ?>" class="t888-about-button button" data-fancybox>
                <i class="lab la-youtube"></i> <?php echo esc_html($button_text); ?>
                </a>
            <?php endif; ?>
        </div>
    </div>
</div>
