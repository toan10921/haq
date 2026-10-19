<?php
$posts_per_page = isset($posts_per_page) ? max(1, (int) $posts_per_page) : 6;
$order = isset($order) && in_array($order, ['ASC', 'DESC'], true) ? $order : 'DESC';
$order_by = isset($order_by) && in_array($order_by, ['date', 'title', 'rand'], true) ? $order_by : 'date';
$categories = !empty($post_categories) ? array_map('intval', (array) $post_categories) : [];
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
    'post_status' => 'publish',
    'posts_per_page' => $posts_per_page,
    'orderby' => $order_by,
    'order' => $order,
    'paged' => $paged,
    'ignore_sticky_posts' => true,
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
} elseif ($categories) {
    $args['tax_query'] = [
        [
            'taxonomy' => 'category',
            'field' => 'term_id',
            'terms' => $categories,
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
            'include' => $categories,
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
    <div class="blog-wrap blog-grid grid-style8">
        <?php if ($paged === 1):
            $query->the_post();
            $featured_id = get_the_ID();
            $featured_permalink = get_permalink($featured_id);
            $featured_title = get_the_title($featured_id);
            $featured_image = get_the_post_thumbnail_url($featured_id, 'large');

            if (!$featured_image) {
                $featured_image = get_theme_mod('general_post_thumbnail_default', '');
            }
            if (!$featured_image) {
                $featured_image = get_template_directory_uri() . '/assets/images/505x273.png';
            }

            $featured_excerpt = get_the_excerpt();
            if ($featured_excerpt === '') {
                $featured_excerpt = wp_strip_all_tags(strip_shortcodes((string) get_the_content()));
            }
            $featured_excerpt = wp_trim_words($featured_excerpt, 36, '...');

            $published = get_post_datetime($featured_id);
            $site_now = new DateTimeImmutable('now', wp_timezone());
            $published_day = $published instanceof DateTimeInterface ? $published->format('Y-m-d') : '';
            $time_label = $published instanceof DateTimeInterface ? wp_date('g:i a', $published->getTimestamp()) : '';

            if ($published_day !== '' && $published_day === $site_now->format('Y-m-d')) {
                $featured_date = sprintf(__('Hôm nay lúc %s', 'nebon'), $time_label);
            } elseif ($published_day !== '' && $published_day === $site_now->modify('-1 day')->format('Y-m-d')) {
                $featured_date = sprintf(__('Hôm qua lúc %s', 'nebon'), $time_label);
            } else {
                $featured_date = get_the_date('d/m/Y', $featured_id);
            }
            ?>
            <article class="post-card8-featured">
                <a class="post-card8-featured-media" href="<?php echo esc_url($featured_permalink); ?>" aria-label="<?php echo esc_attr($featured_title); ?>">
                    <img src="<?php echo esc_url($featured_image); ?>" alt="<?php echo esc_attr($featured_title); ?>">
                </a>
                <div class="post-card8-featured-content">
                    <h2 class="post-card8-featured-title">
                        <a href="<?php echo esc_url($featured_permalink); ?>"><?php echo esc_html($featured_title); ?></a>
                    </h2>
                    <time class="post-card8-featured-date" datetime="<?php echo esc_attr(get_the_date('c', $featured_id)); ?>">
                        <?php echo esc_html($featured_date); ?>
                    </time>
                    <?php if ($featured_excerpt !== '') : ?>
                        <p class="post-card8-featured-excerpt"><?php echo esc_html($featured_excerpt); ?></p>
                    <?php endif; ?>
                    <a class="post-card8-featured-more" href="<?php echo esc_url($featured_permalink); ?>">
                        <?php esc_html_e('Xem thêm', 'nebon'); ?>
                        <i class="las la-arrow-right" aria-hidden="true"></i>
                    </a>
                </div>
            </article>
        <?php endif; ?>

        <?php if ($query->have_posts()): ?>
            <div class="posts-wrap">
                <?php while ($query->have_posts()):
                    $query->the_post();
                    t888f_get_template('posts/loop/grid/grid-style8', '', [], true);
                endwhile; ?>
            </div>
        <?php endif; ?>
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