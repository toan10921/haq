<?php if (get_theme_mod('show_related_post', 'on') === 'on') : ?>
<?php
if (!is_singular('post')) {
    return;
}

$title       = get_theme_mod('related_title', __('RELATED POSTS', 'nebon'));
$icon_class  = get_theme_mod('related_post_heading_icon', 'las la-rainbow');
$num_post    = absint(get_theme_mod('related_num_post', 3)); // fallback = 3
$responsive  = trim(get_theme_mod('related_custom_number', ''));

$current_id  = get_the_ID();
$categories  = get_the_category($current_id);
$cat_ids     = $categories ? wp_list_pluck($categories, 'term_id') : [];

$related_ids = [];
$exclude     = [$current_id];
$need        = $num_post > 0 ? $num_post : 3;

function t888_get_post_ids_by_cats_exact(array $term_ids, int $need, array $exclude = [])
{
    if (empty($term_ids) || $need <= 0) return [];
    $q = new WP_Query([
        'post_type'           => 'post',
        'posts_per_page'      => $need,
        'post__not_in'        => $exclude,
        'ignore_sticky_posts' => 1,
        'tax_query'           => [[
            'taxonomy' => 'category',
            'field'    => 'term_id',
            'terms'    => array_unique(array_map('absint', $term_ids)),
            'include_children' => false,
        ]],
        'fields' => 'ids',
    ]);
    $ids = $q->posts;
    wp_reset_postdata();
    return $ids;
}

if (!empty($cat_ids)) {
    $ids = t888_get_post_ids_by_cats_exact($cat_ids, $need, $exclude);
    $related_ids = array_merge($related_ids, $ids);
    $exclude     = array_merge($exclude, $ids);
    $need        = $need - count($ids);
}

if ($need > 0 && !empty($cat_ids)) {
    $child_ids = [];
    foreach ($cat_ids as $cid) {
        $child_ids = array_merge($child_ids, get_term_children($cid, 'category'));
    }
    $child_ids = array_diff(array_unique(array_map('absint', $child_ids)), $cat_ids);
    if (!empty($child_ids)) {
        $ids = t888_get_post_ids_by_cats_exact($child_ids, $need, $exclude);
        $related_ids = array_merge($related_ids, $ids);
        $exclude     = array_merge($exclude, $ids);
        $need        = $need - count($ids);
    }
}

if ($need > 0 && !empty($categories)) {
    $parent_ids = [];
    foreach ($categories as $c) {
        if (!empty($c->parent)) $parent_ids[] = (int) $c->parent;
    }
    $parent_ids = array_diff(array_unique($parent_ids), $cat_ids);
    if (!empty($parent_ids)) {
        $ids = t888_get_post_ids_by_cats_exact($parent_ids, $need, $exclude);
        $related_ids = array_merge($related_ids, $ids);
        $exclude     = array_merge($exclude, $ids);
        $need        = $need - count($ids);
    }
}

$related_ids = array_values(array_unique($related_ids));
if (!empty($related_ids)) {
    $related_ids = array_slice($related_ids, 0, $num_post ?: 3);
}

if (empty($related_ids)) {
    return;
}

$args = [
    'post_type'           => 'post',
    'posts_per_page'      => count($related_ids),
    'post__in'            => $related_ids,
    'orderby'             => 'post__in',
    'ignore_sticky_posts' => 1,
];

$related_query = new WP_Query($args);

if ($related_query->have_posts()) :
?>
    <div class="related-posts">
        <div class="t888-heading style2">
            <div class="title-wrapper">
                <h3 class="title"><?php echo esc_html($title); ?></h3>
            </div>
        </div>
        <div class="blog-grid">
            <div class="posts-wrap grid-columns-<?php echo esc_attr($num_post ?: 3); ?>">
                <?php while ($related_query->have_posts()) : $related_query->the_post(); ?>
                    <div class="grid-item grid-default">
                        <?php t888f_get_template('posts/loop/grid/grid', '', [], true); ?>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
<?php
endif;
wp_reset_postdata();
?>
<?php endif; ?>