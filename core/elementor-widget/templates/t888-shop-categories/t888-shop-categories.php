<?php
$terms = is_wp_error($terms) ? [] : $terms;
// Always build category links from page 1. Removing only the query argument
// does not remove pretty-permalink paths such as /page/2/.
$category_base_url = get_pagenum_link(1);
$all_url = remove_query_arg(['product_cat', 'product-page', 'paged'], $category_base_url);
$all_text = __('Tất cả', 'nebon');
$default_product_category_id = (int) ($default_product_category_id ?? 0);
$by_parent = [];
foreach ($terms as $term)
    $by_parent[(int) $term->parent][] = $term;
$render_terms = function ($parent = 0) use (&$render_terms, $by_parent, $active_slug, $show_count, $hierarchical, $all_url, $all_text, $default_product_category_id) {
    if (empty($by_parent[$parent]))
        return;
    echo '<ul class="t888-shop-categories__list">';
    foreach ($by_parent[$parent] as $term) {
        $is_all = ($default_product_category_id > 0 && (int) $term->term_id === $default_product_category_id)
            || $term->slug === 'uncategorized';
        $url = $is_all
            ? $all_url
            : add_query_arg('product_cat', $term->slug, $all_url);
        $is_active = $is_all ? $active_slug === '' : $active_slug === $term->slug;
        $label = $is_all ? $all_text : $term->name;
        echo '<li class="t888-shop-categories__item"><a class="t888-shop-categories__link' . ($is_active ? ' is-active' : '') . '" href="' . esc_url($url) . '"><span>' . esc_html($label) . '</span>';
        if (($show_count ?? '') === 'yes')
            echo '<span class="t888-shop-categories__count">(' . esc_html(number_format_i18n($term->count)) . ')</span>';
        echo '</a>';
        if (($hierarchical ?? 'yes') === 'yes')
            $render_terms((int) $term->term_id);
        echo '</li>';
    }
    echo '</ul>';
};
?>
<aside class="t888-shop-categories">
    <?php if (!empty($title)): ?>
        <h3 class="t888-shop-categories__title"><?php echo esc_html($title); ?></h3><?php endif; ?>
    <?php if (($show_all ?? '') === 'yes'): ?>
        <ul class="t888-shop-categories__list t888-shop-categories__list--all">
            <li class="t888-shop-categories__item"><a
                    class="t888-shop-categories__link<?php echo $active_slug === '' ? ' is-active' : ''; ?>"
                    href="<?php echo esc_url($all_url); ?>"><span><?php echo esc_html($all_label ?? $all_text); ?></span></a>
            </li>
        </ul>
    <?php endif; ?>
    <?php if (($hierarchical ?? 'yes') === 'yes'):
        $render_terms(0);
    else: ?>
        <ul class="t888-shop-categories__list">
            <?php foreach ($terms as $term):
                $is_all = ($default_product_category_id > 0 && (int) $term->term_id === $default_product_category_id)
                    || $term->slug === 'uncategorized';
                $url = $is_all ? $all_url : add_query_arg('product_cat', $term->slug, $all_url);
                $is_active = $is_all ? $active_slug === '' : $active_slug === $term->slug;
                $label = $is_all ? $all_text : $term->name; ?>
                <li class="t888-shop-categories__item">
                    <a class="t888-shop-categories__link<?php echo $is_active ? ' is-active' : ''; ?>"
                        href="<?php echo esc_url($url); ?>">
                        <span><?php echo esc_html($label); ?></span>
                        <?php if (($show_count ?? '') === 'yes'): ?><span
                                class="t888-shop-categories__count">(<?php echo esc_html(number_format_i18n($term->count)); ?>)</span><?php endif; ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <?php if (($show_recent_posts ?? 'yes') === 'yes'):
        $r_title = !empty($recent_posts_title) ? $recent_posts_title : __('Bài viết mới nhất', 'nebon');
        $r_count = max(1, (int) ($recent_posts_count ?? 4));
        $recent_posts_query = new \WP_Query([
            'post_type' => 'post',
            'posts_per_page' => $r_count,
            'post_status' => 'publish',
            'orderby' => 'date',
            'order' => 'DESC',
            'ignore_sticky_posts' => true,
        ]);
        if ($recent_posts_query->have_posts()): ?>
            <div class="t888-shop-recent-posts">
                <h3 class="t888-shop-categories__title t888-shop-recent-posts__title"><?php echo esc_html($r_title); ?></h3>
                <div class="t888-shop-recent-posts__list">
                    <?php while ($recent_posts_query->have_posts()):
                        $recent_posts_query->the_post(); ?>
                        <div class="t888-shop-recent-posts__item">
                            <?php if (has_post_thumbnail()): ?>
                                <a href="<?php the_permalink(); ?>" class="t888-shop-recent-posts__thumb"
                                    aria-label="<?php echo esc_attr(get_the_title()); ?>">
                                    <?php the_post_thumbnail('thumbnail'); ?>
                                </a>
                            <?php endif; ?>
                            <div class="t888-shop-recent-posts__content">
                                <h4 class="t888-shop-recent-posts__post-title">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h4>
                                <span class="t888-shop-recent-posts__date">
                                    <i class="lar la-calendar" aria-hidden="true"></i> <?php echo get_the_date(); ?>
                                </span>
                            </div>
                        </div>
                    <?php endwhile;
                    wp_reset_postdata(); ?>
                </div>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</aside>