<?php
$posts_per_page = isset($posts_per_page) ? (int) $posts_per_page : 1;
$order = $order ?? 'DESC';
$order_by = $order_by ?? 'date';
$categories = $post_categories ?? [];
$columns = isset($columns) ? max(1, min(4, (int) $columns)) : 1;
$excerpt_length = isset($excerpt_length) ? max(1, (int) $excerpt_length) : 16;

$args = [
    'post_type' => 'post',
    'post_status' => 'publish',
    'posts_per_page' => $posts_per_page,
    'orderby' => $order_by,
    'order' => $order,
    'ignore_sticky_posts' => true,
];

if (!empty($categories)) {
    $args['tax_query'] = [[
        'taxonomy' => 'category',
        'field' => 'term_id',
        'terms' => array_map('intval', (array) $categories),
    ]];
}

$query = new WP_Query($args);

if ($query->have_posts()) : ?>
    <div class="blog-wrap blog-grid grid-style7">
        <div class="posts-wrap grid-columns-<?php echo esc_attr($columns); ?>">
            <?php while ($query->have_posts()) :
                $query->the_post();
                t888f_get_template(
                    'posts/loop/grid/grid-style7',
                    '',
                    [
                        'excerpt_length' => $excerpt_length,
                    ],
                    true
                );
            endwhile; ?>
        </div>
    </div>
    <?php wp_reset_postdata(); ?>
<?php else : ?>
    <p><?php echo esc_html__('No posts found.', 'nebon'); ?></p>
<?php endif; ?>
