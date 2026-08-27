<?php
if (isset($data) && is_array($data)) {
    extract($data);
}

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
$content = wp_strip_all_tags(strip_shortcodes((string) get_post_field('post_content', $post_id)));
$word_count = count(preg_split('/\s+/u', trim($content), -1, PREG_SPLIT_NO_EMPTY));
$reading_minutes = max(1, (int) ceil($word_count / 200));
?>

<article class="grid-item grid-style8-item">
    <div class="post-card8">
        <div class="post-card8-media-wrap">
            <a class="post-card8-media" href="<?php echo esc_url($permalink); ?>" aria-label="<?php echo esc_attr($title); ?>">
                <img src="<?php echo esc_url($thumbnail_url); ?>" alt="<?php echo esc_attr($title); ?>" loading="lazy">
            </a>

            <?php if ($primary_category) : ?>
                <a class="post-card8-category" href="<?php echo esc_url(get_category_link($primary_category->term_id)); ?>">
                    <?php echo esc_html($primary_category->name); ?>
                </a>
            <?php endif; ?>
        </div>

        <div class="post-card8-content">
            <h3 class="post-card8-title">
                <a href="<?php echo esc_url($permalink); ?>"><?php echo esc_html($title); ?></a>
            </h3>

            <div class="post-card8-meta">
                <span><?php esc_html_e('By', 'nebon'); ?> <strong><?php echo esc_html(get_the_author()); ?></strong></span>
                <span class="post-card8-meta-dot" aria-hidden="true"></span>
                <time datetime="<?php echo esc_attr(get_the_date('c')); ?>"><?php echo esc_html(get_the_date('F j, Y')); ?></time>
            </div>

            <div class="post-card8-footer">
                <span class="post-card8-reading-time">
                    <?php echo esc_html(sprintf(_n('%s min read', '%s min read', $reading_minutes, 'nebon'), number_format_i18n($reading_minutes))); ?>
                </span>
                <a class="post-card8-action" href="<?php echo esc_url($permalink); ?>" aria-label="<?php echo esc_attr(sprintf(__('Read %s', 'nebon'), $title)); ?>">
                    <i class="las la-arrow-right" aria-hidden="true"></i>
                </a>
            </div>
        </div>
    </div>
</article>
