<?php

/**
 * Grid layout for blog posts
 *
 * @package tech888-core
 */

if (isset($data) && is_array($data)) {
    extract($data);
}

$excerpt_length = isset($excerpt_length) ? intval($excerpt_length) : 28;
$custom_size_raw = isset($size) ? trim($size) : '';
$thumb_size = 'post-list3'; 

if (!empty($custom_size_raw)) {
    if (preg_match('/^(\d+)x(\d+)$/', $custom_size_raw, $m)) {
        $w = (int) $m[1];
        $h = (int) $m[2];
        $dynamic = "custom_post_grid_{$w}x{$h}";

        global $_wp_additional_image_sizes;
        if (!isset($_wp_additional_image_sizes[$dynamic])) {
            add_image_size($dynamic, $w, $h, true);
        }
        $thumb_size = $dynamic;
    } else {
        $thumb_size = $custom_size_raw;
    }
}
?>

<div class="grid-item grid-default">
    <div class="post-thumb">
        <a href="<?php echo get_the_permalink(); ?>" class="post-thumb-link default-zoom">
            <?php
            if (has_post_thumbnail()) :
                the_post_thumbnail($thumb_size, array('class' => 'img-responsive'));
            else :
                $fallback_custom = get_theme_mod('general_post_thumbnail_default', '');
                if (! empty($fallback_custom)) {
                    echo '<img class="img-responsive d-block" src="' . esc_url($fallback_custom) . '" alt="' . esc_attr(get_the_title()) . '">';
                } else {
                    echo '<img class="img-responsive d-block" src="' . esc_url(get_template_directory_uri() . '/assets/images/505x273.png') . '" alt="' . esc_attr(get_the_title()) . '">';
                }
            endif;
            ?>
        </a>
    </div>

    <div class="post-info">
        <h4 class="post-title m-0">
            <a class="" href="<?php echo get_the_permalink(); ?>" title="<?php echo get_the_title(); ?>"><?php echo get_the_title(); ?></a>
        </h4>
        <div class="post-meta">
            <span class="date"><?php echo get_the_date('M .j .Y'); ?></span>
            <span class="category"><?php echo get_the_category_list(', '); ?></span>
        </div>
        <div class="post-excerpt">
            <p>
                <?php
                $excerpt = get_the_excerpt();
                $excerpt_trimmed = wp_trim_words($excerpt, $excerpt_length, '');
                echo rtrim($excerpt_trimmed, ".,;:!?") . '...';
                ?>
            </p>
        </div>
        <div class="read-more-share-wrap d-flex flex-wrap  justify-content-between">
            <a href="<?php echo get_the_permalink(); ?>" class="read-more d-inline-block"><?php esc_html_e('Read more', 'nebon'); ?></a>
        </div>
    </div>
</div>