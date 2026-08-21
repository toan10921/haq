<?php
if (isset($data) && is_array($data)) {
    extract($data);
}

$excerpt_length = isset($excerpt_length) ? max(1, (int) $excerpt_length) : 16;
$post_id = get_the_ID();
$permalink = get_the_permalink($post_id);
$title = get_the_title($post_id);
$thumbnail_url = get_the_post_thumbnail_url($post_id, 'full');

if (!$thumbnail_url) {
    $thumbnail_url = get_theme_mod('general_post_thumbnail_default', '');
}
if (!$thumbnail_url) {
    $thumbnail_url = get_template_directory_uri() . '/assets/images/505x273.png';
}

$post_categories = get_the_category($post_id);
$primary_category = !empty($post_categories) ? $post_categories[0] : null;
$excerpt = wp_trim_words(get_the_excerpt($post_id), $excerpt_length, '...');
?>

<article class="grid-item grid-style7-item">
    <div class="split-post-card">
        <div class="split-post-content">
            <div class="split-post-meta">
                <span><?php esc_html_e('By', 'nebon'); ?> <?php echo esc_html(get_the_author()); ?></span>
                <span class="split-post-meta-dot" aria-hidden="true"></span>
                <time datetime="<?php echo esc_attr(get_the_date('c')); ?>"><?php echo esc_html(get_the_date('M j, Y')); ?></time>
            </div>

            <h3 class="split-post-title">
                <a href="<?php echo esc_url($permalink); ?>"><?php echo esc_html($title); ?></a>
            </h3>

            <?php if ($excerpt) : ?>
                <div class="split-post-excerpt"><?php echo esc_html($excerpt); ?></div>
            <?php endif; ?>

            <?php if ($primary_category) : ?>
                <a class="split-post-category" href="<?php echo esc_url(get_category_link($primary_category->term_id)); ?>">
                    <?php echo esc_html($primary_category->name); ?>
                </a>
            <?php endif; ?>
        </div>

        <a class="split-post-media" href="<?php echo esc_url($permalink); ?>" aria-label="<?php echo esc_attr($title); ?>">
            <img src="<?php echo esc_url($thumbnail_url); ?>" alt="<?php echo esc_attr($title); ?>" loading="lazy">
        </a>
    </div>
</article>
