(function ($) {
    "use strict";

    function initPetCategoryCarousel($scope) {
        var $swiperEl = $scope.find('.swiper-pet-category-carousel');
        if (!$swiperEl.length) return;
        
        $swiperEl.each(function() {
            var $this = $(this);
            var columns = parseInt($this.data('columns'), 10) || 5;
            var $container = $this.closest('.swiper-container-wrapper');
            var $nextEl = $container.find('.nav-next')[0];
            var $prevEl = $container.find('.nav-prev')[0];

            if ($this[0].swiper) {
                $this[0].swiper.destroy(true, true);
                $this[0].swiper = null;
            }

            if (!enableSlider) {
                $this.addClass('is-slider-disabled');
                return;
            }

            $this.removeClass('is-slider-disabled');

            var swiperOptions = {
                slidesPerView: 1,
                spaceBetween: 30,
                loop: true,
                navigation: {
                    nextEl: $nextEl,
                    prevEl: $prevEl,
                },
                breakpoints: {
                    576: { slidesPerView: 2 },
                    768: { slidesPerView: 3 },
                    992: { slidesPerView: 4 },
                    1200: { slidesPerView: columns }
                }
            };


            var initSwiper = function() {
                if (typeof Swiper !== 'undefined') {
                    new Swiper($this[0], swiperOptions);
                } else if (typeof elementorFrontend !== 'undefined' && elementorFrontend.utils && elementorFrontend.utils.swiper) {
                    new elementorFrontend.utils.swiper($this, swiperOptions).then(function(newSwiperInstance) {
                        $this[0].swiper = newSwiperInstance;
                    });
                }
            };

            initSwiper();
        });
    }

    $(window).on('load', function() {
        setTimeout(function() {
            initPetCategoryCarousel($(document));
        }, 500);
    });

    $(window).on('elementor/frontend/init', function () {
        if (typeof elementorFrontend === 'undefined' || !elementorFrontend.hooks) return;
        elementorFrontend.hooks.addAction('frontend/element_ready/t888-pet-category-carousel.default', function($scope) {
            initPetCategoryCarousel($scope);
        });
    });

})(jQuery);
