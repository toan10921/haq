(function ($) {
    "use strict";

    function initPetProductCarousel($scope) {
        var $swiperEl = $scope.find('.swiper-pet-product-carousel');
        if (!$swiperEl.length) return;
        
        $swiperEl.each(function() {
            var $this = $(this);
            var columns = parseInt($this.data('columns'), 10) || 5;
            var $container = $this.closest('.t888-pet-product-module');
            var $nextEl = $container.find('.nav-next')[0];
            var $prevEl = $container.find('.nav-prev')[0];
            
            var slideCount = $this.find('.swiper-slide').length;
            
            // Hack to force infinite loop: Swiper disables loop if elements <= columns
            if (slideCount > 0 && slideCount <= columns) {
                var $wrapper = $this.find('.swiper-wrapper');
                $wrapper.append($wrapper.html());
            }
            
            var swiperOptions = {
                slidesPerView: 1,
                spaceBetween: 30,
                loop: true,
                autoplay: {
                    delay: 5000,
                    disableOnInteraction: false,
                },
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
                if ($this[0].swiper) {
                    $this[0].swiper.destroy(true, true);
                }
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
            initPetProductCarousel($('.t888-pet-product-module'));
        }, 500);
    });

    $(window).on('elementor/frontend/init', function () {
        if (typeof elementorFrontend === 'undefined' || !elementorFrontend.hooks) return;
        elementorFrontend.hooks.addAction('frontend/element_ready/t888-pet-product-carousel.default', function($scope) {
            initPetProductCarousel($scope);
        });
    });

})(jQuery);
