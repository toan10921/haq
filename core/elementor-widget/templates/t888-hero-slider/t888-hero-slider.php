<?php
$slides = (isset($slides) && is_array($slides)) ? $slides : [];
$widget_id = isset($widget_id) ? sanitize_html_class($widget_id) : wp_unique_id('hero-');

$t888_banner_image = static function ($image) {
    return is_array($image) ? $image : [];
};

$t888_banner_url = static function ($image) {
    if (!empty($image['id'])) {
        $url = wp_get_attachment_image_url((int) $image['id'], 'full');
        if ($url) return $url;
    }

    return !empty($image['url']) ? $image['url'] : '';
};

$t888_banner_srcset = static function ($image) use ($t888_banner_url) {
    if (!empty($image['id'])) {
        $srcset = wp_get_attachment_image_srcset((int) $image['id'], 'full');
        if ($srcset) return $srcset;
    }

    return $t888_banner_url($image);
};
?>
<section
    id="t888-industrial-hero-<?php echo esc_attr($widget_id); ?>"
    class="t888-industrial-hero"
    role="region"
    aria-roledescription="<?php esc_attr_e('carousel', 'nebon'); ?>"
    aria-label="<?php esc_attr_e('Industrial banner slider', 'nebon'); ?>"
    tabindex="0"
>
    <div class="t888-industrial-hero__slides">
        <?php foreach ($slides as $index => $slide) :
            $desktop_image = $t888_banner_image($slide['background_image'] ?? []);
            $tablet_image = $t888_banner_image($slide['background_image_tablet'] ?? []);
            $mobile_image = $t888_banner_image($slide['background_image_mobile'] ?? []);

            if ($t888_banner_url($desktop_image) === '') {
                $desktop_image = $t888_banner_url($tablet_image) !== '' ? $tablet_image : $mobile_image;
            }

            if ($t888_banner_url($tablet_image) === '') {
                $tablet_image = $desktop_image;
            }

            if ($t888_banner_url($mobile_image) === '') {
                $mobile_image = $tablet_image;
            }

            $desktop_url = $t888_banner_url($desktop_image);
            $tablet_srcset = $t888_banner_srcset($tablet_image);
            $mobile_srcset = $t888_banner_srcset($mobile_image);
            $alt = isset($slide['image_alt']) ? trim((string) $slide['image_alt']) : '';

            if ($alt === '' && !empty($desktop_image['id'])) {
                $alt = (string) get_post_meta((int) $desktop_image['id'], '_wp_attachment_image_alt', true);
            }

            $is_active = $index === 0;
        ?>
            <article
                class="t888-industrial-hero__slide elementor-repeater-item-<?php echo esc_attr($slide['_id'] ?? ''); ?><?php echo $is_active ? ' is-active' : ''; ?>"
                data-slide-index="<?php echo esc_attr($index); ?>"
                aria-hidden="<?php echo $is_active ? 'false' : 'true'; ?>"
            >
                <?php if ($desktop_url !== '') : ?>
                    <picture class="t888-industrial-hero__picture">
                        <?php if ($mobile_srcset !== '') : ?>
                            <source media="(max-width: 767px)" srcset="<?php echo esc_attr($mobile_srcset); ?>" sizes="100vw">
                        <?php endif; ?>
                        <?php if ($tablet_srcset !== '') : ?>
                            <source media="(max-width: 1024px)" srcset="<?php echo esc_attr($tablet_srcset); ?>" sizes="100vw">
                        <?php endif; ?>

                        <?php if (!empty($desktop_image['id'])) : ?>
                            <?php echo wp_get_attachment_image(
                                (int) $desktop_image['id'],
                                'full',
                                false,
                                [
                                    'class' => 't888-industrial-hero__image',
                                    'alt' => $alt,
                                    'loading' => $is_active ? 'eager' : 'lazy',
                                    'decoding' => 'async',
                                    'fetchpriority' => $is_active ? 'high' : 'auto',
                                    'sizes' => '100vw',
                                ]
                            ); ?>
                        <?php else : ?>
                            <img
                                class="t888-industrial-hero__image"
                                src="<?php echo esc_url($desktop_url); ?>"
                                alt="<?php echo esc_attr($alt); ?>"
                                loading="<?php echo $is_active ? 'eager' : 'lazy'; ?>"
                                decoding="async"
                                <?php echo $is_active ? 'fetchpriority="high"' : ''; ?>
                            >
                        <?php endif; ?>
                    </picture>
                <?php endif; ?>
            </article>
        <?php endforeach; ?>
    </div>

    <?php if (count($slides) > 1) : ?>
        <div class="t888-industrial-hero__arrows" aria-label="<?php esc_attr_e('Slider navigation', 'nebon'); ?>">
            <button class="t888-industrial-hero__arrow t888-industrial-hero__prev" type="button" aria-label="<?php esc_attr_e('Previous slide', 'nebon'); ?>">
                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M19 12H5M11 18l-6-6 6-6"/></svg>
            </button>
            <button class="t888-industrial-hero__arrow t888-industrial-hero__next" type="button" aria-label="<?php esc_attr_e('Next slide', 'nebon'); ?>">
                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
            </button>
        </div>
    <?php endif; ?>

    <?php if (empty($slides) && current_user_can('edit_theme_options')) : ?>
        <div class="t888-industrial-hero__empty"><?php esc_html_e('Add banner images to the slider.', 'nebon'); ?></div>
    <?php endif; ?>
</section>
