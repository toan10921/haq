<?php
  $list = empty($list) ? [] : $list;
?>
<div class="t888-testimonial swiper-container eltech888-swiper-slider"
            data-items="1"
            data-space="50"
            data-loop="true"
            data-speed="5000"
            data-autoplay="yes"
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
                        <i class="las la-quote-left"></i>
                            <p class="content-testimonial"><?php echo esc_html($item['content']); ?></p>
                            <p class="name-testimonial"><?php echo esc_html($item['title']); ?></p>
                </div>
                    </div>
                <?php endforeach; ?>
            </div>
          
        </div>