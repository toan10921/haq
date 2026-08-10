<?php
$categories = !empty($categories_list) && is_array($categories_list) ? $categories_list : [];
$items_per_slide = !empty($items_per_slide) ? max(1, intval($items_per_slide)) : 5;
$enable_slider = isset($enable_slider) && $enable_slider === 'yes';
$slider_autoplay = isset($slider_autoplay) && $slider_autoplay === 'yes';
$slider_autoplay_delay = !empty($slider_autoplay_delay) ? intval($slider_autoplay_delay) : 3;
$widget_id = uniqid('pet-cate-carousel-home2-');
?>

<div class="pet-cate-carousel-home2 swiper-container-wrapper" id="<?php echo esc_attr($widget_id); ?>">
    <div class="pet-cate-carousel-home2__header d-flex align-items-center justify-content-between">
        <?php if (!empty($title)) : ?>
            <h3 class="pet-cate-carousel-home2__title"><?php echo esc_html($title); ?></h3>
        <?php endif; ?>

        <div class="pet-cate-carousel-home2__nav<?php echo !$enable_slider ? ' is-hidden' : ''; ?>">
            <button class="nav-prev" aria-label="<?php esc_attr_e('Previous', 'nebon'); ?>">
                <i class="las la-angle-left"></i>
            </button>
            <button class="nav-next" aria-label="<?php esc_attr_e('Next', 'nebon'); ?>">
                <i class="las la-angle-right"></i>
            </button>
        </div>
    </div>

    <div
        class="swiper pet-cate-carousel-home2__swiper<?php echo !$enable_slider ? ' is-slider-disabled' : ''; ?>"
        data-items-per-slide="<?php echo esc_attr($items_per_slide); ?>"
        data-enable-slider="<?php echo esc_attr($enable_slider ? 'yes' : 'no'); ?>"
        data-autoplay="<?php echo esc_attr($slider_autoplay ? 'yes' : 'no'); ?>"
        data-autoplay-delay="<?php echo esc_attr($slider_autoplay_delay); ?>"
    >
        <div class="swiper-wrapper">
            <?php foreach ($categories as $item) : ?>
                <?php
                $cat_id = !empty($item['category_select']) ? intval($item['category_select']) : 0;
                $cat = $cat_id ? get_term_by('id', $cat_id, 'product_cat') : false;
                $item_title = !empty($item['custom_title']) ? $item['custom_title'] : ($cat ? $cat->name : __('Category', 'nebon'));
                $item_count = $cat ? sprintf(__('%s items', 'nebon'), $cat->count) : __('0 items', 'nebon');
                $item_link = $cat ? get_term_link($cat) : '#';
                if (is_wp_error($item_link)) {
                    $item_link = '#';
                }
                $image_url = !empty($item['category_image']['url']) ? $item['category_image']['url'] : '';
                $repeater_class = !empty($item['_id']) ? 'elementor-repeater-item-' . $item['_id'] : '';
                ?>
                <div class="swiper-slide pet-cate-carousel-home2__slide <?php echo esc_attr($repeater_class); ?>">
                    <a href="<?php echo esc_url($item_link); ?>" class="pet-cate-carousel-home2__card-link">
                        <article class="pet-cate-carousel-home2__card">
                            <?php if ($image_url) : ?>
                                <div class="pet-cate-carousel-home2__image">
                                    <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($item_title); ?>">
                                </div>
                            <?php endif; ?>

                            <div class="pet-cate-carousel-home2__content">
                                <h4 class="pet-cate-carousel-home2__card-title"><?php echo esc_html($item_title); ?></h4>
                                <span class="pet-cate-carousel-home2__count"><?php echo esc_html($item_count); ?></span>
                            </div>
                        </article>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
