<?php
$posts_per_page = isset($posts_per_page) ? (int) $posts_per_page : 6;
$order          = $order ?? 'DESC';
$order_by       = $order_by ?? 'date';
$categories     = $post_categories ?? [];
$style          = $style ?? ($settings['style'] ?? 'masonry');
$columns        = isset($columns) ? (int) $columns : (int) ($settings['columns'] ?? 2);
$gutter_spacing = $gutter_spacing ?? ($settings['gutter_spacing'] ?? 'gutter-20');

$paged = max(1, (int) get_query_var('paged'), (int) get_query_var('page'));

$args = [
    'post_type'      => 'post',
    'posts_per_page' => $posts_per_page,
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
    <div class="blog-wrap blog-grid masonry-grid <?php echo esc_attr($gutter_spacing); ?>">
        <div class="posts-wrap grid-columns-<?php echo esc_attr($columns); ?>">
            <div class="grid-sizer"></div>

            <?php while ($query->have_posts()) : $query->the_post(); ?>
                <?php
                $settings['size'] = ($style === 'style4') ? 'full' : 'post-list3';

                t888f_get_template(
                    'posts/loop/grid/grid',
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
