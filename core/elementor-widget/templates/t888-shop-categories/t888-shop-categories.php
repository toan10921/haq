<?php
$terms = is_wp_error($terms) ? [] : $terms;
$all_url = remove_query_arg(['product_cat', 'product-page', 'paged']);
$all_text = __('Tất cả', 'nebon');
$default_product_category_id = (int) ($default_product_category_id ?? 0);
$by_parent = [];
foreach ($terms as $term) $by_parent[(int) $term->parent][] = $term;
$render_terms = function ($parent = 0) use (&$render_terms, $by_parent, $active_slug, $show_count, $hierarchical, $all_url, $all_text, $default_product_category_id) {
    if (empty($by_parent[$parent])) return;
    echo '<ul class="t888-shop-categories__list">';
    foreach ($by_parent[$parent] as $term) {
        $is_all = ($default_product_category_id > 0 && (int) $term->term_id === $default_product_category_id)
            || $term->slug === 'uncategorized';
        $url = $is_all
            ? $all_url
            : add_query_arg('product_cat', $term->slug, remove_query_arg(['product-page', 'paged']));
        $is_active = $is_all ? $active_slug === '' : $active_slug === $term->slug;
        $label = $is_all ? $all_text : $term->name;
        echo '<li class="t888-shop-categories__item"><a class="t888-shop-categories__link' . ($is_active ? ' is-active' : '') . '" href="' . esc_url($url) . '"><span>' . esc_html($label) . '</span>';
        if (($show_count ?? '') === 'yes') echo '<span class="t888-shop-categories__count">(' . esc_html(number_format_i18n($term->count)) . ')</span>';
        echo '</a>';
        if (($hierarchical ?? 'yes') === 'yes') $render_terms((int) $term->term_id);
        echo '</li>';
    }
    echo '</ul>';
};
?>
<aside class="t888-shop-categories">
    <?php if (!empty($title)) : ?><h3 class="t888-shop-categories__title"><?php echo esc_html($title); ?></h3><?php endif; ?>
    <?php if (($show_all ?? '') === 'yes') : ?>
        <ul class="t888-shop-categories__list t888-shop-categories__list--all">
            <li class="t888-shop-categories__item"><a class="t888-shop-categories__link<?php echo $active_slug === '' ? ' is-active' : ''; ?>" href="<?php echo esc_url($all_url); ?>"><span><?php echo esc_html($all_label ?? $all_text); ?></span></a></li>
        </ul>
    <?php endif; ?>
    <?php if (($hierarchical ?? 'yes') === 'yes') :
        $render_terms(0);
    else : ?>
        <ul class="t888-shop-categories__list">
            <?php foreach ($terms as $term) :
                $is_all = ($default_product_category_id > 0 && (int) $term->term_id === $default_product_category_id)
                    || $term->slug === 'uncategorized';
                $url = $is_all ? $all_url : add_query_arg('product_cat', $term->slug, remove_query_arg(['product-page', 'paged']));
                $is_active = $is_all ? $active_slug === '' : $active_slug === $term->slug;
                $label = $is_all ? $all_text : $term->name; ?>
                <li class="t888-shop-categories__item">
                    <a class="t888-shop-categories__link<?php echo $is_active ? ' is-active' : ''; ?>" href="<?php echo esc_url($url); ?>">
                        <span><?php echo esc_html($label); ?></span>
                        <?php if (($show_count ?? '') === 'yes') : ?><span class="t888-shop-categories__count">(<?php echo esc_html(number_format_i18n($term->count)); ?>)</span><?php endif; ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</aside>
