(function ($) {
    "use strict";

    function createSwiperInstance($swiperEl, swiperOptions) {
        if (typeof Swiper !== 'undefined') {
            var instance = new Swiper($swiperEl[0], swiperOptions);
            $swiperEl[0].swiper = instance;
            return;
        }

        if (typeof elementorFrontend !== 'undefined' && elementorFrontend.utils && elementorFrontend.utils.swiper) {
            new elementorFrontend.utils.swiper($swiperEl, swiperOptions).then(function (newSwiperInstance) {
                $swiperEl[0].swiper = newSwiperInstance;
            });
        }
    }

    function initPetCateCarouselHome2($scope) {
        var $modules = $scope.hasClass('pet-cate-carousel-home2')
            ? $scope
            : $scope.find('.pet-cate-carousel-home2');

        if (!$modules.length) {
            return;
        }

        $modules.each(function () {
            var $module = $(this);
            var $swiperEl = $module.find('.pet-cate-carousel-home2__swiper').first();

            if (!$swiperEl.length) {
                return;
            }

            var itemsPerSlide = parseInt($swiperEl.attr('data-items-per-slide'), 10) || 5;
            var enableSlider = $swiperEl.attr('data-enable-slider') === 'yes';
            var autoplayEnabled = $swiperEl.attr('data-autoplay') === 'yes';
            var autoplayDelaySeconds = parseInt($swiperEl.attr('data-autoplay-delay'), 10) || 3;
            var $nextEl = $module.find('.nav-next')[0];
            var $prevEl = $module.find('.nav-prev')[0];
            var slideCount = $swiperEl.find('.swiper-slide').length;
            var computedGap = window.getComputedStyle($swiperEl[0]).getPropertyValue('--pet-cate-carousel-home2-gap');
            var spaceBetween = parseInt(computedGap, 10);

            if (isNaN(spaceBetween)) {
                spaceBetween = 15;
            }

            if ($swiperEl[0].swiper) {
                $swiperEl[0].swiper.destroy(true, true);
                $swiperEl[0].swiper = null;
            }

            if (!enableSlider || slideCount <= 1) {
                $swiperEl.addClass('is-slider-disabled');
                return;
            }

            $swiperEl.removeClass('is-slider-disabled');

            var swiperOptions = {
                slidesPerView: 1,
                spaceBetween: spaceBetween,
                loop: slideCount > itemsPerSlide,
                navigation: {
                    nextEl: $nextEl,
                    prevEl: $prevEl
                },
                breakpoints: {
                    576: { slidesPerView: Math.min(2, itemsPerSlide) },
                    768: { slidesPerView: Math.min(3, itemsPerSlide) },
                    992: { slidesPerView: Math.min(4, itemsPerSlide) },
                    1200: { slidesPerView: itemsPerSlide }
                }
            };

            swiperOptions.autoplay = autoplayEnabled ? {
                delay: autoplayDelaySeconds * 1000,
                disableOnInteraction: false,
                pauseOnMouseEnter: true
            } : false;

            createSwiperInstance($swiperEl, swiperOptions);
        });
    }

    $(window).on('load', function () {
        setTimeout(function () {
            initPetCateCarouselHome2($(document));
        }, 300);
    });

    $(window).on('elementor/frontend/init', function () {
        if (typeof elementorFrontend === 'undefined' || !elementorFrontend.hooks) {
            return;
        }

        elementorFrontend.hooks.addAction('frontend/element_ready/pet-cate-carousel-home2.default', function ($scope) {
            initPetCateCarouselHome2($scope);
        });
    });
})(jQuery);
