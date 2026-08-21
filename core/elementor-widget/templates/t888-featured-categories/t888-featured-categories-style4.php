<?php
$category_items = isset($category_list) && is_array($category_list) ? $category_list : [];
$desktop_slides = max(1, min(4, (int) ($style4_slides_desktop ?? 3)));
$tablet_slides = max(1, min(3, (int) ($style4_slides_tablet ?? 2)));
$mobile_slides = max(1, min(2, (int) ($style4_slides_mobile ?? 1)));
$slide_gap = max(0, min(100, (int) ($style4_gap ?? 30)));
$autoplay_delay = max(1000, min(15000, (int) ($style4_autoplay_delay ?? 4500)));
$transition_speed = max(200, min(3000, (int) ($style4_transition_speed ?? 650)));
$show_navigation = ($style4_navigation ?? 'yes') === 'yes';
$categories = [];

foreach ($category_items as $item) {
    $term_id = !empty($item['category_select']) ? absint($item['category_select']) : 0;
    $term = $term_id ? get_term($term_id, 'product_cat') : null;

    if (!$term || is_wp_error($term)) {
        continue;
    }

    $term_link = get_term_link($term);
    if (is_wp_error($term_link)) {
        continue;
    }

    $placeholder_url = \Elementor\Utils::get_placeholder_image_src();
    $image_url = !empty($item['category_image']['url']) ? $item['category_image']['url'] : '';
    if ($image_url === $placeholder_url) {
        $image_url = '';
    }
    if (!$image_url) {
        $thumbnail_id = absint(get_term_meta($term_id, 'thumbnail_id', true));
        $image_url = $thumbnail_id ? wp_get_attachment_image_url($thumbnail_id, 'full') : '';
    }
    if (!$image_url) {
        $image_url = $placeholder_url;
    }

    $categories[] = [
        'name' => $term->name,
        'count' => (int) $term->count,
        'link' => $term_link,
        'image' => $image_url,
    ];
}
?>

<?php if (!empty($categories)) : ?>
    <div class="t888-category-showcase">
        <div
            class="t888-category-showcase__slider swiper"
            data-t888-category-slider
            data-slides-desktop="<?php echo esc_attr($desktop_slides); ?>"
            data-slides-tablet="<?php echo esc_attr($tablet_slides); ?>"
            data-slides-mobile="<?php echo esc_attr($mobile_slides); ?>"
            data-slide-gap="<?php echo esc_attr($slide_gap); ?>"
            data-autoplay="<?php echo esc_attr(($style4_autoplay ?? 'yes') === 'yes' ? 'yes' : 'no'); ?>"
            data-autoplay-delay="<?php echo esc_attr($autoplay_delay); ?>"
            data-transition-speed="<?php echo esc_attr($transition_speed); ?>"
            data-loop="<?php echo esc_attr(($style4_loop ?? 'yes') === 'yes' ? 'yes' : 'no'); ?>"
        >
            <div class="swiper-wrapper">
                <?php foreach ($categories as $category) : ?>
                    <article class="category-showcase-slide swiper-slide">
                        <a class="category-showcase-card" href="<?php echo esc_url($category['link']); ?>">
                            <span class="category-showcase-media">
                                <img src="<?php echo esc_url($category['image']); ?>" alt="<?php echo esc_attr($category['name']); ?>" loading="lazy">
                            </span>
                            <span class="category-showcase-overlay" aria-hidden="true"></span>

                            <span class="category-showcase-content">
                                <span class="category-showcase-count">
                                    <?php echo esc_html(sprintf(_n('%s product', '%s products', $category['count'], 'nebon'), number_format_i18n($category['count']))); ?>
                                </span>
                                <span class="category-showcase-title"><?php echo esc_html($category['name']); ?></span>
                                <span class="category-showcase-action" aria-hidden="true">&#8594;</span>
                            </span>
                        </a>
                    </article>
                <?php endforeach; ?>
            </div>

            <?php if ($show_navigation) : ?>
                <button class="category-showcase-nav category-showcase-nav--prev" type="button" aria-label="<?php esc_attr_e('Previous product categories', 'nebon'); ?>">
                    <span aria-hidden="true">&#8592;</span>
                </button>
                <button class="category-showcase-nav category-showcase-nav--next" type="button" aria-label="<?php esc_attr_e('Next product categories', 'nebon'); ?>">
                    <span aria-hidden="true">&#8594;</span>
                </button>
            <?php endif; ?>
        </div>
    </div>
<?php elseif (current_user_can('edit_posts')) : ?>
    <p><?php esc_html_e('Choose at least one product category for this slider.', 'nebon'); ?></p>
<?php endif; ?>
