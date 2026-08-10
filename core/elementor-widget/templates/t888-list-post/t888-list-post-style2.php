<?php
$posts_per_page = $posts_per_page ?? 6;
$order          = $order ?? 'DESC';
$order_by       = $order_by ?? 'date';
$categories     = $post_categories ?? [];
$style          = $style ?? ($settings['style'] ?? 'list');

$paged = max(1, (int) get_query_var('paged'), (int) get_query_var('page'));

$args = [
    'post_type'      => 'post',
    'posts_per_page' => (int) $posts_per_page,
    'orderby'        => $order_by,
    'order'          => $order,
    'paged'          => $paged,
];

if (!empty($categories)) {
    $args['tax_query'] = [[
        'taxonomy' => 'category',
        'field'    => 'term_id',
        'terms'    => array_map('intval', (array) $categories),
    ]];
}

$query = new WP_Query($args);

if ($query->have_posts()) : ?>
    <div class="blog-wrap blog-list">
        <div class="posts-wrap">
            <?php while ($query->have_posts()) : $query->the_post(); ?>
                <?php
                t888f_get_template(
                    'posts/loop/list/list-style2',
                    $slug ?? 'post',
                    $settings ?? [],
                    true
                );
                ?>
            <?php endwhile; ?>
        </div>
    </div>

<?php
    tech888f_paging_nav($query, 'style2', true);

    wp_reset_postdata();

else :
    echo '<p>' . esc_html__('No posts found.', 'nebon') . '</p>';
endif;
