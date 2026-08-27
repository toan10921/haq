<?php
$list = $list ?? [];
$main_image_url = !empty($style3_image['url']) ? $style3_image['url'] : '';
?>
<section class="t888-testimonial-style3">
    <div class="t888-testimonial-style3__visual">
        <?php if ($main_image_url) : ?>
            <img
                class="t888-testimonial-style3__image"
                src="<?php echo esc_url($main_image_url); ?>"
                alt="<?php echo esc_attr($style3_heading ?? __('Client testimonials', 'nebon')); ?>">
        <?php endif; ?>
    </div>

    <div class="t888-testimonial-style3__content">
        <header class="t888-testimonial-style3__header">
            <?php if (!empty($style3_eyebrow)) : ?>
                <p class="t888-testimonial-style3__eyebrow">
                    <span aria-hidden="true">&#187;</span>
                    <?php echo esc_html($style3_eyebrow); ?>
                </p>
            <?php endif; ?>

            <?php if (!empty($style3_heading)) : ?>
                <h2 class="t888-testimonial-style3__heading"><?php echo esc_html($style3_heading); ?></h2>
            <?php endif; ?>
        </header>

        <div class="t888-testimonial style3 swiper-container eltech888-swiper-slider"
            data-items="1"
            data-space="30"
            data-loop="yes"
            data-speed="5000"
            data-autoplay="no"
            data-navigation="yes"
            data-pagination="bullets"
            data-effect="slide"
            data-items-widescreen="1"
            data-items-laptop="1"
            data-items-tablet-extra="1"
            data-items-tablet="1"
            data-items-mobile-extra="1"
            data-items-mobile="1">
            <div class="swiper-wrapper">
                <?php foreach ($list as $item) : ?>
                    <article class="swiper-slide">
                        <div class="t888-testimonial-style3__slide">
                            <div class="t888-testimonial-style3__quote-head">
                                <?php if (!empty($item['avatar']['url'])) : ?>
                                    <img
                                        class="t888-testimonial-style3__avatar"
                                        src="<?php echo esc_url($item['avatar']['url']); ?>"
                                        alt="<?php echo esc_attr($item['title'] ?? ''); ?>">
                                <?php endif; ?>

                                <div>
                                    <?php if (!empty($item['quote_title'])) : ?>
                                        <h3 class="t888-testimonial-style3__quote-title"><?php echo esc_html($item['quote_title']); ?></h3>
                                    <?php endif; ?>
                                    <?php if (!empty($item['content'])) : ?>
                                        <p class="t888-testimonial-style3__quote"><?php echo esc_html($item['content']); ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="t888-testimonial-style3__meta">
                                <span class="t888-testimonial-style3__quote-mark" aria-hidden="true">&#8221;</span>
                                <div class="t888-testimonial-style3__author">
                                    <?php if (!empty($item['title'])) : ?>
                                        <p class="t888-testimonial-style3__name"><?php echo esc_html($item['title']); ?></p>
                                    <?php endif; ?>
                                    <?php if (!empty($item['position'])) : ?>
                                        <p class="t888-testimonial-style3__position"><?php echo esc_html($item['position']); ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>

            <div class="t888-testimonial-style3__controls">
                <div class="swiper-pagination" aria-hidden="true"></div>
                <div class="t888-testimonial-style3__arrows">
                    <button class="swiper-button-prev" type="button" aria-label="<?php echo esc_attr__('Previous testimonial', 'nebon'); ?>">
                        <i class="las la-arrow-left" aria-hidden="true"></i>
                    </button>
                    <button class="swiper-button-next" type="button" aria-label="<?php echo esc_attr__('Next testimonial', 'nebon'); ?>">
                        <i class="las la-arrow-right" aria-hidden="true"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>
