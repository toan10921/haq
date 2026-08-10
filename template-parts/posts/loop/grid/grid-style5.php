<?php

/**
 * Grid style 5 for blog posts
 *
 * @package tech888-core
 */

if (isset($data) && is_array($data)) {
    extract($data);
}

$excerpt_length = isset($excerpt_length) ? intval($excerpt_length) : 50;
$thumb_size = 'medium_large';

?>

<div class="grid-item grid-style5-item">
    <div class="grid-style5-card">
        <div class="post-thumb">
            <a href="<?php echo get_the_permalink(); ?>" class="post-thumb-link">
                <?php
if (has_post_thumbnail()):
    the_post_thumbnail($thumb_size, array('class' => 'img-responsive'));
else:
    $fallback_custom = get_theme_mod('general_post_thumbnail_default', '');
    if (!empty($fallback_custom)) {
        echo '<img class="img-responsive d-block" src="' . esc_url($fallback_custom) . '" alt="' . esc_attr(get_the_title()) . '">';
    }
    else {
        echo '<img class="img-responsive d-block" src="' . esc_url(get_template_directory_uri() . '/assets/images/505x273.png') . '" alt="' . esc_attr(get_the_title()) . '">';
    }
endif;
?>
            </a>
            <div class="post-date-badge">
                <span class="day"><?php echo get_the_date('d'); ?></span>
                <span class="month"><?php echo strtolower(get_the_date('M')); ?></span>
            </div>
        </div>

        <div class="post-info">
            <div class="post-meta">
                <span class="author"><?php the_author(); ?></span>
            </div>
            <h3 class="post-title">
                <a href="<?php echo get_the_permalink(); ?>" title="<?php echo get_the_title(); ?>"><?php echo get_the_title(); ?></a>
            </h3>
            <div class="post-excerpt">
                <p>
                    <?php
echo wp_trim_words(get_the_excerpt(), $excerpt_length, '...');
?>
                </p>
            </div>
            <a href="<?php echo get_the_permalink(); ?>" class="read-more">
                <?php esc_html_e('Read more >', 'nebon'); ?>
            </a>
        </div>
    </div>
</div>
