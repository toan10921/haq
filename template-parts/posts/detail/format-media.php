<?php
$hide_thumbnail = isset($hide_thumbnail) ? (bool) $hide_thumbnail : false;
if ($hide_thumbnail) return;

$global_show = get_theme_mod('show_thumbnail_media', 'on'); // customizer
$show_thumbnail_meta = get_post_meta(get_the_ID(), 'custom_post_show_thumbnail', true);
$show_thumbnail = ($show_thumbnail_meta === '1');
$format = get_post_format(get_the_ID()) ?: 'standard';

$print_featured = function () {
    if (has_post_thumbnail()) {
        echo '<div class="post-media post-media--featured">';
        the_post_thumbnail('full', ['class' => 'img-fluid w-100', 'loading' => 'lazy', 'decoding' => 'async']);
        echo '</div>';
    }
};

switch ($format) {
    case 'gallery':
        $ids = [];

        if (function_exists('rwmb_meta')) {
            $images = rwmb_meta('custom_post_detail_gallery'); // field image_advanced
            if (is_array($images)) {
                foreach ($images as $img) {
                    if (is_array($img) && isset($img['ID'])) {
                        $ids[] = absint($img['ID']);
                    } elseif (is_numeric($img)) {
                        $ids[] = absint($img);
                    }
                }
            }
        }

        if (empty($ids)) {
            $raw = get_post_meta(get_the_ID(), 'custom_post_detail_gallery', true);
            if (is_string($raw)) {
                $ids = array_filter(array_map('absint', array_map('trim', explode(',', $raw))));
            } elseif (is_array($raw)) {
                $ids = array_map('absint', $raw);
            }
        }

        $ids = array_values(array_unique(array_filter($ids)));

        if (!empty($ids)) : ?>
            <div class="post-media post-media--gallery">
                <div class="swiper-container eltech888-swiper-slider format-gallery-slider"
                    data-items="4"
                    data-space="20"
                    data-loop="false"
                    data-navigation="true"
                    data-pagination="bullets"
                    data-speed="3000"
                    data-effect="slide"
                    data-items-widescreen="5"
                    data-items-laptop="4"
                    data-items-tablet-extra="3"
                    data-items-tablet="3"
                    data-items-mobile-extra="2"
                    data-items-mobile="2"
                    data-space-widescreen="10"
                    data-space-laptop="10"
                    data-space-tablet-extra="10"
                    data-space-tablet="10"
                    data-space-mobile-extra="10"
                    data-space-mobile="10">
                    <div class="swiper-wrapper products">
                        <?php
                        $desired = 'product-list-default';
                        foreach ($ids as $aid): ?>
                            <div class="swiper-slide">
                                <div class="t888-ratio-327x482">
                                    <?php
                                    $has_crop = (bool) image_get_intermediate_size($aid, $desired);
                                    echo wp_get_attachment_image(
                                        $aid,
                                        $has_crop ? $desired : 'large',
                                        false,
                                        [
                                            'class'    => 'gallery-image',
                                            'loading'  => 'lazy',
                                            'decoding' => 'async',
                                            'sizes'    => '(min-width:1024px) 25vw, 50vw',
                                        ]
                                    );
                                    ?>
                                </div>
                            </div>
                        <?php endforeach; ?>

                    </div>
                    <div class="swiper-pagination t888-pagination-line"></div>
                </div>
            </div>
<?php
        else:
            if (isset($print_featured) && is_callable($print_featured)) $print_featured();
            elseif (has_post_thumbnail()) {
                echo '<div class="post-media post-media--featured">';
                the_post_thumbnail('large', ['class' => 'featured-image', 'loading' => 'lazy', 'decoding' => 'async']);
                echo '</div>';
            }
        endif;
        break;




    case 'image':
        $print_featured();
        break;

    case 'video':
        $video_url = trim(get_post_meta(get_the_ID(), 'custom_post_content_media', true));
        $video_html = '';

        if ($video_url) {
            $video_html = wp_oembed_get($video_url);
            if (!$video_html && preg_match('/\.(mp4|webm|ogg)$/i', $video_url)) {
                $video_html = wp_video_shortcode([
                    'src'     => esc_url($video_url),
                    'preload' => 'metadata',
                    'class'   => 'w-100',
                ]);
            }
        }

        if (!$video_html) {
            $upload_id = get_post_meta(get_the_ID(), 'video_1', true);
            if ($upload_id) {
                $upload_src = wp_get_attachment_url($upload_id);
                if ($upload_src) {
                    $video_html = wp_video_shortcode([
                        'src'     => esc_url($upload_src),
                        'preload' => 'metadata',
                        'class'   => 'w-100',
                    ]);
                }
            }
        }

        if ($video_html) {
            echo '<div class="post-media post-media--video responsive-embed">' . $video_html . '</div>';
        }
        break;
    case 'audio':
        $audio_html = '';

        $audio_url = trim((string) get_post_meta(get_the_ID(), 'audio_embed', true));
        if ($audio_url) {
            $audio_html = wp_oembed_get($audio_url);

            if (!$audio_html && preg_match('/\.(mp3|ogg|wav)$/i', $audio_url)) {
                $audio_html = wp_audio_shortcode([
                    'src'     => esc_url($audio_url),
                    'preload' => 'metadata',
                    'class'   => 'w-100',
                ]);
            }
        }

        if (!$audio_html) {
            $audio_id = get_post_meta(get_the_ID(), 'audio_11', true);
            if ($audio_id) {
                $audio_src = wp_get_attachment_url($audio_id);
                if ($audio_src) {
                    $audio_html = wp_audio_shortcode([
                        'src'     => esc_url($audio_src),
                        'preload' => 'metadata',
                        'class'   => 'w-100',
                    ]);
                }
            }
        }

        if ($audio_html) {
            echo '<div class="post-media post-media--audio">' . $audio_html . '</div>';
        }
        break;



    case 'quote':
        break;

    default: // STANDARD
        if ($show_thumbnail && $format === 'standard') {
            $print_featured();
        }
        break;
}
