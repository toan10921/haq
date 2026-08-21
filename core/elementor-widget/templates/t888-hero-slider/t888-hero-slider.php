<?php
$slides = (isset($slides) && is_array($slides)) ? $slides : [];
$widget_id = isset($widget_id) ? sanitize_html_class($widget_id) : wp_unique_id('hero-');
$allowed_title_tags = ['h1', 'h2', 'h3', 'div'];
$title_tag = (isset($title_tag) && in_array($title_tag, $allowed_title_tags, true)) ? $title_tag : 'h1';
$show_sidebar = isset($show_sidebar) ? $show_sidebar === 'yes' : true;

$t888_hero_link_attributes = static function ($link, $fallback = '') {
    $link = is_array($link) ? $link : [];
    $url = !empty($link['url']) ? $link['url'] : $fallback;
    if ($url === '') return '';

    $attributes = ' href="' . esc_url($url) . '"';
    if (!empty($link['is_external'])) $attributes .= ' target="_blank"';

    $rel = [];
    if (!empty($link['nofollow'])) $rel[] = 'nofollow';
    if (!empty($link['is_external'])) $rel[] = 'noopener noreferrer';
    if ($rel) $attributes .= ' rel="' . esc_attr(implode(' ', $rel)) . '"';

    return $attributes;
};
?>
<section
    id="t888-industrial-hero-<?php echo esc_attr($widget_id); ?>"
    class="t888-industrial-hero<?php echo $show_sidebar ? ' has-contact-sidebar' : ''; ?>"
    role="region"
    aria-roledescription="<?php esc_attr_e('carousel', 'nebon'); ?>"
    aria-label="<?php esc_attr_e('Industrial hero slider', 'nebon'); ?>"
    tabindex="0"
>
    <?php if ($show_sidebar) :
        $phone_label = isset($sidebar_phone_label) ? trim((string) $sidebar_phone_label) : '';
        $phone = isset($sidebar_phone) ? trim((string) $sidebar_phone) : '';
        $phone_fallback = $phone !== '' ? 'tel:' . preg_replace('/[^0-9+]/', '', $phone) : '';
        $email_label = isset($sidebar_email_label) ? trim((string) $sidebar_email_label) : '';
        $email = isset($sidebar_email) ? trim((string) $sidebar_email) : '';
        $email_fallback = $email !== '' ? 'mailto:' . sanitize_email($email) : '';
        $scroll_label = !empty($sidebar_scroll_label) ? (string) $sidebar_scroll_label : __('Scroll to content', 'nebon');
        $scroll_attributes = $t888_hero_link_attributes($sidebar_scroll_link ?? [], '#main-content');
    ?>
        <aside class="t888-industrial-hero__sidebar" aria-label="<?php esc_attr_e('Contact information', 'nebon'); ?>">
            <div class="t888-industrial-hero__contacts">
                <?php if ($phone !== '') : ?>
                    <a class="t888-industrial-hero__contact-link"<?php echo apply_filters('tech888f_output_content', $t888_hero_link_attributes($sidebar_phone_link ?? [], $phone_fallback)); ?>>
                        <?php if ($phone_label !== '') : ?><span><?php echo esc_html($phone_label); ?></span><?php endif; ?>
                        <span><?php echo esc_html($phone); ?></span>
                    </a>
                <?php endif; ?>

                <?php if ($phone !== '' && $email !== '') : ?>
                    <span class="t888-industrial-hero__contact-divider" aria-hidden="true"></span>
                <?php endif; ?>

                <?php if ($email !== '') : ?>
                    <a class="t888-industrial-hero__contact-link"<?php echo apply_filters('tech888f_output_content', $t888_hero_link_attributes($sidebar_email_link ?? [], $email_fallback)); ?>>
                        <?php if ($email_label !== '') : ?><span><?php echo esc_html($email_label); ?></span><?php endif; ?>
                        <span><?php echo esc_html($email); ?></span>
                    </a>
                <?php endif; ?>
            </div>

            <?php if ($scroll_attributes !== '') : ?>
                <a class="t888-industrial-hero__sidebar-scroll"<?php echo apply_filters('tech888f_output_content', $scroll_attributes); ?> aria-label="<?php echo esc_attr($scroll_label); ?>">
                    <span class="t888-industrial-hero__sidebar-scroll-line" aria-hidden="true"></span>
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M6 9l6 6 6-6"/></svg>
                </a>
            <?php endif; ?>
        </aside>
    <?php endif; ?>

    <div class="t888-industrial-hero__slides">
        <?php foreach ($slides as $index => $slide) :
            $background = (isset($slide['background_image']) && is_array($slide['background_image'])) ? $slide['background_image'] : [];
            $background_url = !empty($background['url']) ? $background['url'] : '';
            $title = isset($slide['title']) ? (string) $slide['title'] : '';
            $description = isset($slide['description']) ? (string) $slide['description'] : '';
            $button_text = isset($slide['button_text']) ? (string) $slide['button_text'] : '';
            $button_link = (isset($slide['button_link']) && is_array($slide['button_link'])) ? $slide['button_link'] : [];
            $button_url = !empty($button_link['url']) ? $button_link['url'] : '#';
            $button_target = !empty($button_link['is_external']) ? ' target="_blank"' : '';
            $button_rel = [];
            if (!empty($button_link['nofollow'])) $button_rel[] = 'nofollow';
            if (!empty($button_link['is_external'])) $button_rel[] = 'noopener noreferrer';
            $button_rel_attr = $button_rel ? ' rel="' . esc_attr(implode(' ', $button_rel)) . '"' : '';

            $play_link = (isset($slide['play_link']) && is_array($slide['play_link'])) ? $slide['play_link'] : [];
            $play_url = !empty($play_link['url']) ? $play_link['url'] : '';
            $play_target = !empty($play_link['is_external']) ? ' target="_blank"' : '';
            $play_rel = [];
            if (!empty($play_link['nofollow'])) $play_rel[] = 'nofollow';
            if (!empty($play_link['is_external'])) $play_rel[] = 'noopener noreferrer';
            $play_rel_attr = $play_rel ? ' rel="' . esc_attr(implode(' ', $play_rel)) . '"' : '';
            $is_active = $index === 0;
        ?>
            <article
                class="t888-industrial-hero__slide elementor-repeater-item-<?php echo esc_attr($slide['_id'] ?? ''); ?><?php echo $is_active ? ' is-active' : ''; ?>"
                data-slide-index="<?php echo esc_attr($index); ?>"
                aria-hidden="<?php echo $is_active ? 'false' : 'true'; ?>"
            >
                <div class="t888-industrial-hero__background">
                    <?php if ($background_url !== '') : ?>
                        <?php if (!empty($background['id'])) : ?>
                            <?php echo wp_get_attachment_image(
                                (int) $background['id'],
                                'full',
                                false,
                                [
                                    'alt' => '',
                                    'loading' => 'eager',
                                    'decoding' => 'async',
                                    'fetchpriority' => $index === 0 ? 'high' : 'auto',
                                    'sizes' => '100vw',
                                ]
                            ); ?>
                        <?php else : ?>
                            <img src="<?php echo esc_url($background_url); ?>" alt="" loading="eager" decoding="async"<?php echo $index === 0 ? ' fetchpriority="high"' : ''; ?>>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
                <div class="t888-industrial-hero__overlay"></div>

                <div class="t888-industrial-hero__container">
                    <div class="t888-industrial-hero__content">
                        <?php if ($title !== '') : ?>
                            <div class="t888-industrial-hero__title-wrap">
                                <div class="t888-industrial-hero__title-mask">
                                    <<?php echo esc_attr($title_tag); ?> class="t888-industrial-hero__title">
                                        <?php echo wp_kses_post(nl2br(esc_html($title))); ?>
                                    </<?php echo esc_attr($title_tag); ?>>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if ($description !== '') : ?>
                            <div class="t888-industrial-hero__description-wrap">
                                <div class="t888-industrial-hero__description">
                                    <?php echo wp_kses_post(wpautop($description)); ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <div class="t888-industrial-hero__actions">
                            <?php if ($button_text !== '') : ?>
                                <div class="t888-industrial-hero__button-wrap">
                                    <a class="t888-industrial-hero__button" href="<?php echo esc_url($button_url); ?>"<?php echo apply_filters('tech888f_output_content', $button_target . $button_rel_attr); ?>>
                                        <span><?php echo esc_html($button_text); ?></span>
                                        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                                    </a>
                                </div>
                            <?php endif; ?>

                            <?php if ($play_url !== '') : ?>
                                <div class="t888-industrial-hero__play-wrap">
                                    <a class="t888-industrial-hero__play" href="<?php echo esc_url($play_url); ?>" aria-label="<?php esc_attr_e('Play video', 'nebon'); ?>"<?php echo apply_filters('tech888f_output_content', $play_target . $play_rel_attr); ?>>
                                        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M9 7l8 5-8 5V7z"/></svg>
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
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
        <div class="t888-industrial-hero__empty"><?php esc_html_e('Add slides in the Hero Slides repeater.', 'nebon'); ?></div>
    <?php endif; ?>
</section>
