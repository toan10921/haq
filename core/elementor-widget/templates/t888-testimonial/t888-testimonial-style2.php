<?php
$list = $list ?? [];
?>
<div class="t888-testimonial style2 swiper-container eltech888-swiper-slider"
    data-items="1"
    data-space="50"
    data-loop="true"
    data-speed="5000"
    data-autoplay="no"
    data-pagination="bullets"
    data-effect="slide"
    data-items-widescreen="1"
    data-items-laptop="1"
    data-items-tablet-extra="1"
    data-items-tablet="1"
    data-items-mobile-extra="1"
    data-items-mobile="1"
    data-space-widescreen="50"
    data-space-laptop="50"
    data-space-tablet-extra="25"
    data-space-tablet="20"
    data-space-mobile-extra="15"
    data-space-mobile="10">
    <div class="swiper-wrapper">
        <?php foreach ($list as $item) : ?>
            <div class="swiper-slide">
                <div class="swiper-inner-testimonial">
                    <div class="testimonial-head">
                        <div class="testimonial-author">
                            <?php if (!empty($item['avatar']['url'])) : ?>
                                <img class="testimonial-avatar"
                                    src="<?php echo esc_url($item['avatar']['url']); ?>"
                                    alt="<?php echo esc_attr($item['title']); ?>">
                            <?php endif; ?>
                            <div class="testimonial-author-info">
                                <p class="name-testimonial"><?php echo esc_html($item['title']); ?></p>
                                <?php if (!empty($item['position'])) : ?>
                                    <p class="position-testimonial"><?php echo esc_html($item['position']); ?></p>
                                <?php endif; ?>
                            </div>
                        </div>

                        <?php if (!empty($item['company_logo']['url'])) : ?>
                            <img class="testimonial-company-logo"
                                src="<?php echo esc_url($item['company_logo']['url']); ?>"
                                alt="<?php echo esc_attr($item['title']); ?>">
                        <?php endif; ?>
                    </div>

                    <p class="content-testimonial"><?php echo esc_html($item['content']); ?></p>

                    <div class="testimonial-footer">
                        <div class="rating-stars">
                            <?php
                            $rating = isset($item['rating']) ? max(1, min(5, (int) $item['rating'])) : 5;
                            for ($i = 1; $i <= 5; $i++) :
                            ?>
                                <i class="<?php echo $i <= $rating ? 'las' : 'lar'; ?> la-star"></i>
                            <?php endfor; ?>
                        </div>
                        <div class="testimonial-quote-mark" aria-hidden="true">
                            <svg viewBox="0 0 63 46" role="presentation" focusable="false">
                                <path d="M1 1h27v27L15 43V28H1V1Z"></path>
                                <path d="M34 1h28v27L49 43V28H34V1Z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="swiper-pagination t888-pagination-line"></div>
</div>
