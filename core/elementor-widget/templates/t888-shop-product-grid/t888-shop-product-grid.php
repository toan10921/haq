<?php
$show_filter = ($show_category_filter ?? '') === 'yes';
if ($show_filter) :
    $filter_base_url = remove_query_arg(['product_cat', 'product-page', 'paged']);
    $all_is_active = empty($active_category_slug);
    ?>
    <nav class="t888-shop-categories" aria-label="<?php esc_attr_e('Product categories', 'nebon'); ?>">
        <div class="t888-shop-categories__list" role="list">
            <a
                class="t888-shop-categories__link<?php echo $all_is_active ? ' is-active' : ''; ?>"
                href="<?php echo esc_url($filter_base_url); ?>"
                data-product-category=""
                <?php echo $all_is_active ? 'aria-current="true"' : ''; ?>
            ><?php echo esc_html(!empty($all_categories_label) ? $all_categories_label : __('Tất cả', 'nebon')); ?></a>
            <?php foreach ((array) ($filter_categories ?? []) as $category) :
                $is_active = ($active_category_slug ?? '') === $category->slug;
                $category_url = add_query_arg('product_cat', $category->slug, $filter_base_url);
                ?>
                <a
                    class="t888-shop-categories__link<?php echo $is_active ? ' is-active' : ''; ?>"
                    href="<?php echo esc_url($category_url); ?>"
                    data-product-category="<?php echo esc_attr($category->slug); ?>"
                    <?php echo $is_active ? 'aria-current="true"' : ''; ?>
                ><?php echo esc_html($category->name); ?></a>
            <?php endforeach; ?>
        </div>
    </nav>
<?php endif; ?>

<?php
$shop_filter_config = [
    'productsPerPage'       => max(1, (int) ($products_per_page ?? 9)),
    'categories'            => array_values(array_filter(array_map('absint', (array) ($categories ?? [])))),
    'showSaleBadge'         => ($show_sale_badge ?? 'yes') === 'yes',
    'showContactButton'     => ($show_contact_button ?? 'yes') === 'yes',
    'contactButtonText'     => (string) ($contact_button_text ?? __('Liên hệ', 'nebon')),
    'contactButtonUrl'      => (string) ($contact_button_link['url'] ?? '#'),
    'contactButtonExternal' => !empty($contact_button_link['is_external']),
    'contactButtonNofollow' => !empty($contact_button_link['nofollow']),
    'showPagination'        => ($show_pagination ?? 'yes') === 'yes',
];
?>
<div
    class="t888-shop-results"
    data-active-category="<?php echo esc_attr($active_category_slug ?? ''); ?>"
    data-filter-config="<?php echo esc_attr(wp_json_encode($shop_filter_config)); ?>"
    aria-live="polite"
>
<?php if ($query->have_posts()) : ?>
    <div class="t888-shop-grid" role="list">
        <?php while ($query->have_posts()) : $query->the_post();
            $product = wc_get_product(get_the_ID());
            if (!$product) continue; ?>
            <article class="t888-shop-card" role="listitem">
                <div class="t888-shop-card__media">
                    <a class="t888-shop-card__image" href="<?php the_permalink(); ?>" aria-label="<?php echo esc_attr($product->get_name()); ?>">
                        <?php echo wp_kses_post($product->get_image('woocommerce_thumbnail', ['loading' => 'lazy'])); ?>
                        <?php if (($show_sale_badge ?? 'yes') === 'yes' && $product->is_on_sale()) : ?>
                            <span class="t888-shop-card__sale"><?php esc_html_e('Sale!', 'nebon'); ?></span>
                        <?php endif; ?>
                    </a>
                    <?php if (($show_contact_button ?? 'yes') === 'yes') :
                        $contact_url = !empty($contact_button_link['url']) ? $contact_button_link['url'] : '#';
                        $contact_target = !empty($contact_button_link['is_external']) ? ' target="_blank"' : '';
                        $contact_rel = !empty($contact_button_link['nofollow']) ? ' rel="nofollow"' : '';
                        ?>
                        <a
                            class="t888-shop-card__contact"
                            href="<?php echo esc_url($contact_url); ?>"
                            <?php echo $contact_target; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                            <?php echo $contact_rel; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
                        >
                            <span class="t888-shop-card__contact-text"><?php echo esc_html(!empty($contact_button_text) ? $contact_button_text : __('Liên hệ', 'nebon')); ?></span>
                            <span class="t888-shop-card__contact-icon" aria-hidden="true">
                                <svg viewBox="0 0 24 24"><path d="M7 17 17 7M10 7h7v7"/></svg>
                            </span>
                        </a>
                    <?php endif; ?>
                </div>
                <div class="t888-shop-card__meta">
                    <div class="t888-shop-card__price"><?php echo wp_kses_post($product->get_price_html()); ?></div>
                    <h3 class="t888-shop-card__title"><a href="<?php the_permalink(); ?>"><?php echo esc_html($product->get_name()); ?></a></h3>
                </div>
            </article>
        <?php endwhile; ?>
    </div>

    <?php if (($show_pagination ?? 'yes') === 'yes' && $query->max_num_pages > 1) :
        $pagination_url = !empty($pagination_base_url)
            ? add_query_arg('product-page', '999999999', $pagination_base_url)
            : add_query_arg('product-page', '999999999');
        $base = str_replace('999999999', '%#%', esc_url_raw($pagination_url)); ?>
        <nav class="t888-shop-pagination" aria-label="<?php esc_attr_e('Product pagination', 'nebon'); ?>">
            <?php echo wp_kses_post(paginate_links([
                'base' => $base, 'format' => '', 'current' => $current_page, 'total' => (int) $query->max_num_pages,
                'prev_text' => '&#8592;', 'next_text' => '&#8594;', 'type' => 'list',
            ])); ?>
        </nav>
    <?php endif; ?>
<?php else : ?>
    <p class="t888-shop-grid__empty"><?php echo esc_html($empty_text ?? __('No products found.', 'nebon')); ?></p>
<?php endif; wp_reset_postdata(); ?>
</div>
