<?php
$categories = $categories_list ?? [];
$car_columns = !empty($columns) ? intval($columns) : 5;
$widget_id = uniqid('pet-cat-');
?>

<div class="t888-pet-category-carousel swiper-container-wrapper" id="<?php echo esc_attr($widget_id); ?>">
    <div class="header-nav-wrap d-flex align-items-center justify-content-between">
        <?php if (!empty($title)) : ?>
            <h3 class="main-title"><?php echo esc_html($title); ?></h3>
        <?php endif; ?>

        <div class="header-nav<?php echo !$enable_slider ? ' is-hidden' : ''; ?>">
            <button class="nav-prev" aria-label="Previous">
                <i class="las la-angle-left"></i>
            </button>
            <button class="nav-next" aria-label="Next">
                <i class="las la-angle-right"></i>
            </button>
        </div>
    </div>

    <div
        class="swiper swiper-pet-category-carousel<?php echo !$enable_slider ? ' is-slider-disabled' : ''; ?>"
        data-columns="<?php echo esc_attr($car_columns); ?>"
        data-enable-slider="<?php echo esc_attr($enable_slider ? 'yes' : 'no'); ?>"
        data-autoplay="<?php echo esc_attr($slider_autoplay ? 'yes' : 'no'); ?>"
        data-autoplay-delay="<?php echo esc_attr($slider_autoplay_delay); ?>"
        style="--t888-desktop-columns: <?php echo esc_attr($car_columns); ?>;"
    >
        <div class="swiper-wrapper">
            <?php foreach ($categories as $index => $item) : 
                $cat_id = $item['category_select'] ?? '';
                $cat = $cat_id ? get_term_by('id', $cat_id, 'product_cat') : false;
                
                $title = !empty($item['custom_title']) ? $item['custom_title'] : ($cat ? $cat->name : 'Category');
                $count = $cat ? $cat->count . ' items' : '0 items';
                $link = $cat ? get_term_link($cat) : '#';

                $image_html = '';
                if (!empty($item['category_image']['url'])) {
                    $image_html = '<img src="' . esc_url($item['category_image']['url']) . '" alt="' . esc_attr($title) . '" class="cat-img" />';
                }
                
                $repeater_class = isset($item['_id']) ? 'elementor-repeater-item-' . esc_attr($item['_id']) : '';
            ?>
                <div class="swiper-slide pet-cat-slide-item <?php echo $repeater_class; ?>">
                    <a href="<?php echo esc_url($link); ?>" class="cat-box-link">
                        <div class="cat-box-bg">
                            <?php echo $image_html; ?>
                            <div class="cat-text-wrap">
                                <h4 class="cat-title"><?php echo esc_html($title); ?></h4>
                                <span class="cat-count"><?php echo esc_html($count); ?></span>
                            </div>
                        </div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
