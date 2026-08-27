<?php
$posts_per_page = isset($posts_per_page) ? max(1, (int) $posts_per_page) : 6;
$order = isset($order) && in_array($order, ['ASC', 'DESC'], true) ? $order : 'DESC';
$order_by = isset($order_by) && in_array($order_by, ['date', 'title', 'rand'], true) ? $order_by : 'date';
$categories = !empty($post_categories) ? array_map('intval', (array) $post_categories) : [];

$args = [
    'post_type' => 'post',
    'post_status' => 'publish',
    'posts_per_page' => $posts_per_page,
    'orderby' => $order_by,
    'order' => $order,
    'ignore_sticky_posts' => true,
];

if ($categories) {
    $args['tax_query'] = [[
        'taxonomy' => 'category',
        'field' => 'term_id',
        'terms' => $categories,
    ]];
}

$query = new WP_Query($args);

if ($query->have_posts()) : ?>
    <div class="blog-wrap blog-grid grid-style8">
        <div class="posts-wrap">
            <?php while ($query->have_posts()) :
                $query->the_post();
                t888f_get_template('posts/loop/grid/grid-style8', '', [], true);
            endwhile; ?>
        </div>
    </div>
    <?php wp_reset_postdata(); ?>
<?php else : ?>
    <p><?php echo esc_html__('No posts found.', 'nebon'); ?></p>
<?php endif; ?>
