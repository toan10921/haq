<?php

$uploaded_video = !empty($uploaded_video) ? $uploaded_video : '';
$autoplay       = $autoplay === 'yes' ? 1 : 0;
$mute           = $mute === 'yes' ? 1 : 0;
$loop           = $loop === 'yes' ? 1 : 0;
$controls       = $controls === 'yes' ? 1 : 0;
$overlay_image  = !empty($overlay_image) ? $overlay_image['url'] : '';

?>

<div class="t888-video-wrapper" style="position: relative; max-width: 100%; aspect-ratio: 26 / 11;">
    <?php if ($overlay_image): ?>
        <div class="t888-video-overlay" style="position: absolute; inset: 0; display:contents;">
            <img src="<?php echo esc_url($overlay_image); ?>" alt="Video Thumbnail" class="t888-video-thumbnail">
            <div class="t888-play-button">
                <i class="las la-play"></i>
            </div>
        </div>
        <div class="t888-video-frame" style="display: none; width: 100%; height: 100%; position: relative;"></div>
    <?php else: ?>
        <div class="t888-video-frame" style="width: 100%; height: 100%; position: relative;">
            <?php if ($video_type === 'youtube'): ?>
                <iframe
                    src="https://www.youtube.com/embed/<?php echo esc_attr(extract_youtube_id($youtube_link)); ?>?autoplay=<?php echo esc_attr($autoplay); ?>&mute=<?php echo esc_attr($mute); ?>&loop=<?php echo esc_attr($loop); ?>&controls=<?php echo esc_attr($controls); ?>"
                    frameborder="0"
                    allow="autoplay; encrypted-media"
                    allowfullscreen
                    style="width: 100%; height: 100%; position: absolute; top: 0; left: 0;">
                </iframe>
            <?php elseif ($video_type === 'upload'): ?>
                <video
                    src="<?php echo esc_url($uploaded_video); ?>"
                    <?php echo esc_attr($autoplay ? 'autoplay' : ''); ?>
                    <?php echo esc_attr($mute ? 'muted' : ''); ?>
                    <?php echo esc_attr($loop ? 'loop' : ''); ?>

                    style="width: 100%; height: 100%; object-fit: cover;">
                </video>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>



