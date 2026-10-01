<?php
$posts_per_page = $posts_per_page ?? 6;
$order = $order ?? 'DESC';
$order_by = $order_by ?? 'date';
$categories = $post_categories ?? [];
$style = $style ?? ($settings['style'] ?? 'list');
$show_category_filter = $show_category_filter ?? 'no';
$show_pagination = $show_pagination ?? 'yes';
$pagination_style = $pagination_style ?? 'style2';
$filter_all_label = $filter_all_label ?? __('Tất cả', 'nebon');

$paged = max(1, (int) get_query_var('paged'), (int) get_query_var('page'));
if (isset($_GET['paged'])) {
    $paged = max(1, (int) $_GET['paged']);
}
$active_cat = isset($_GET['post_cat']) ? sanitize_text_field($_GET['post_cat']) : 'all';

$args = [
    'post_type' => 'post',
    'posts_per_page' => $posts_per_page,
    'orderby' => $order_by,
    'order' => $order,
    'paged' => $paged,
];

if ($active_cat !== 'all' && !empty($active_cat)) {
    $field = is_numeric($active_cat) ? 'term_id' : 'slug';
    $args['tax_query'] = [
        [
            'taxonomy' => 'category',
            'field' => $field,
            'terms' => $active_cat,
        ]
    ];
} elseif (!empty($categories)) {
    $args['tax_query'] = [
        [
            'taxonomy' => 'category',
            'field' => 'term_id',
            'terms' => array_map('intval', (array) $categories),
        ]
    ];
}

$query = new WP_Query($args);
?>

<?php if ($show_category_filter === 'yes'):
    $filter_terms = [];
    if (!empty($categories)) {
        $filter_terms = get_terms([
            'taxonomy' => 'category',
            'include' => array_map('intval', (array) $categories),
            'hide_empty' => true,
        ]);
    } else {
        $filter_terms = get_terms([
            'taxonomy' => 'category',
            'hide_empty' => true,
        ]);
    }
    ?>
    <div class="t888-post-category-filter">
        <ul class="filter-tabs">
            <li class="filter-tab-item <?php echo ($active_cat === 'all') ? 'active' : ''; ?>">
                <a href="<?php echo esc_url(remove_query_arg(['post_cat', 'paged'])); ?>" class="filter-link"
                    data-cat="all">
                    <?php echo esc_html($filter_all_label); ?>
                </a>
            </li>
            <?php if (!empty($filter_terms) && !is_wp_error($filter_terms)): ?>
                <?php foreach ($filter_terms as $term):
                    $is_active = ($active_cat === $term->slug || $active_cat == $term->term_id);
                    $url = add_query_arg('post_cat', $term->slug, remove_query_arg('paged'));
                    ?>
                    <li class="filter-tab-item <?php echo $is_active ? 'active' : ''; ?>">
                        <a href="<?php echo esc_url($url); ?>" class="filter-link" data-cat="<?php echo esc_attr($term->slug); ?>">
                            <?php echo esc_html($term->name); ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            <?php endif; ?>
        </ul>
    </div>
<?php endif; ?>

<?php if ($query->have_posts()): ?>
    <div class="blog-wrap blog-list">
        <div class="posts-wrap">
            <?php while ($query->have_posts()):
                $query->the_post(); ?>
                <?php
                t888f_get_template(
                    "posts/loop/list/list",
                    $slug ?? 'post',
                    $settings ?? [],
                    true
                );
                ?>
            <?php endwhile; ?>
        </div>
    </div>

    <?php
    if ($show_pagination === 'yes') {
        tech888f_paging_nav($query, $pagination_style, true);
    }
    wp_reset_postdata();
?>
<?php else: ?>
    <p><?php echo esc_html__('No posts found.', 'nebon'); ?></p>
<?php endif; ?>