<?php
$title = $title ?? ($settings['title'] ?? '');
$items = $items ?? ($settings['items'] ?? []); // nhận từ render()
?>

<div class="t888-list-gallery style1">
    <?php if (!empty($title)) : ?>
        <h2 class="t888-list-gallery-title"><?php echo esc_html($title); ?></h2>
    <?php endif; ?>

    <div class="t888-list-gallery-items eltech888-swiper-slider"
         data-items="6"
         data-space="145"
         data-loop="true"
         data-navigation="true"
         data-speed="5000"
         data-autoplay="yes"
         data-effect="slide"
         data-items-widescreen="5"
         data-items-laptop="4"
         data-items-tablet-extra="3"
         data-items-tablet="3"
         data-items-mobile-extra="2"
         data-items-mobile="2"
         data-space-widescreen="40"
         data-space-laptop="30"
         data-space-tablet-extra="25"
         data-space-tablet="20"
         data-space-mobile-extra="15"
         data-space-mobile="10">

        <div class="swiper-wrapper list-gallery-wrapper-logo">
            <?php if (!empty($items)) : ?>
                <?php foreach ($items as $i => $it) :
                    $img_id  = $it['item_image']['id']  ?? 0;
                    $img_url = $it['item_image']['url'] ?? '';
                    $link    = $it['item_link']['url']   ?? '';
                    $is_ext  = !empty($it['item_link']['is_external']);
                    $nofollow= !empty($it['item_link']['nofollow']);

                    $target  = $is_ext ? ' target="_blank"' : '';
                    $relArr  = [];
                    if ($nofollow) $relArr[] = 'nofollow';
                    if ($is_ext)   $relArr[] = 'noopener';
                    $relAttr = $relArr ? ' rel="'.esc_attr(implode(' ', $relArr)).'"' : '';

                    // alt
                    $alt = '';
                    if ($img_id) {
                        $alt = get_post_meta($img_id, '_wp_attachment_image_alt', true);
                    }
                    $alt = $alt ?: get_bloginfo('name');
                ?>
                    <div class="t888-list-gallery-item swiper-slide">
                        <div class="t888-list-gallery-image-inner">
                            <?php if ($link) : ?>
                                <a href="<?php echo esc_url($link); ?>"<?php echo esc_attr( $target . $relAttr ); ?> aria-label="gallery item <?php echo esc_attr($i+1); ?>">
                            <?php endif; ?>

                            <?php
                            if ($img_id) {
                                echo wp_get_attachment_image($img_id, 'large', false, [
                                    'class'   => 't888-gallery-img',
                                    'loading' => 'lazy',
                                    'alt'     => $alt,
                                ]);
                            } elseif ($img_url) {
                                // fallback khi ảnh là URL rời
                                echo '<img class="t888-gallery-img" src="'.esc_url($img_url).'" alt="'.esc_attr($alt).'" loading="lazy">';
                            }
                            ?>

                            <?php if ($link) : ?>
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <p><?php echo esc_html__('No images found.', 'nebon'); ?></p>
            <?php endif; ?>
        </div>

        <div class="swiper-button-prev"><i class="las la-angle-left"></i></div>
        <div class="swiper-button-next"><i class="las la-angle-right"></i></div>
    </div>
</div>
