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

    function initPetShopCarousel($scope) {
        var $modules = $scope.hasClass('t888-pet-shop-carousel-module')
            ? $scope
            : $scope.find('.t888-pet-shop-carousel-module');
        if (!$modules.length) {
            return;
        }

        function buildSwiper($swiperEl) {
            if (!$swiperEl.length) {
                return;
            }

            var columns = parseInt($swiperEl.data('columns'), 10) || 6;
            var $container = $swiperEl.closest('.t888-pet-shop-carousel-module');
            var $nextEl = $container.find('.nav-next')[0];
            var $prevEl = $container.find('.nav-prev')[0];
            var slideCount = $swiperEl.find('.swiper-slide').length;
            var autoplayEnabled = String($container.data('autoplay')) === 'yes';
            var autoplayDelay = parseInt($container.data('autoplay-delay'), 10) || 5000;

            if (slideCount <= 0) {
                return;
            }

            if (slideCount > 0 && slideCount <= columns && !$swiperEl.data('cloned')) {
                var $wrapper = $swiperEl.find('.swiper-wrapper');
                $wrapper.append($wrapper.html());
                $swiperEl.data('cloned', true);
            }

            var swiperOptions = {
                slidesPerView: 2,
                spaceBetween: 10,
                loop: true,
                autoplay: autoplayEnabled ? {
                    delay: autoplayDelay,
                    disableOnInteraction: false
                } : false,
                navigation: {
                    nextEl: $nextEl,
                    prevEl: $prevEl
                },
                breakpoints: {
                    576: { slidesPerView: 2 },
                    768: { slidesPerView: 3 },
                    992: { slidesPerView: 4 },
                    1200: { slidesPerView: columns }
                }
            };

            if ($swiperEl[0].swiper) {
                $swiperEl[0].swiper.destroy(true, true);
            }
            createSwiperInstance($swiperEl, swiperOptions);
        }

        function activateTab($module, $tab) {
            var $allTabs = $module.find('.pet-shop-carousel-tab-trigger');
            var $panels = $module.find('.pet-shop-carousel-panel');
            var target = $tab.data('tab-target');
            var $panel = $panels.filter('[data-tab-panel="' + target + '"]');

            if (!$panel.length) {
                return;
            }

            $allTabs.removeClass('is-active').attr('aria-selected', 'false');
            $tab.addClass('is-active').attr('aria-selected', 'true');

            $panels.removeClass('is-active').attr('hidden', true);
            $panel.addClass('is-active').removeAttr('hidden');

            setTimeout(function () {
                buildSwiper($panel.find('.swiper-pet-shop-carousel').first());
            }, 10);
        }

        function bindGlobalTabEvents() {
            if ($(document).data('t888PetShopTabsBound')) {
                return;
            }

            $(document).on('click.t888PetShopTabs', '.t888-pet-shop-carousel-module .pet-shop-carousel-tab-trigger', function (event) {
                event.preventDefault();
                event.stopPropagation();
                activateTab($(this).closest('.t888-pet-shop-carousel-module'), $(this));
            });

            $(document).on('keydown.t888PetShopTabs', '.t888-pet-shop-carousel-module .pet-shop-carousel-tab-trigger', function (event) {
                if (event.key === 'Enter' || event.key === ' ') {
                    event.preventDefault();
                    event.stopPropagation();
                    activateTab($(this).closest('.t888-pet-shop-carousel-module'), $(this));
                }
            });

            $(document).data('t888PetShopTabsBound', true);
        }

        bindGlobalTabEvents();

        $modules.each(function () {
            var $module = $(this);
            var $tabTriggers = $module.find('.pet-shop-carousel-tab-trigger');
            var $activeSwiper = $module.find('.pet-shop-carousel-panel.is-active .swiper-pet-shop-carousel').first();

            $tabTriggers.off('click.t888PetShopTabsLocal keydown.t888PetShopTabsLocal');
            $tabTriggers.on('click.t888PetShopTabsLocal', function (event) {
                event.preventDefault();
                event.stopPropagation();
                activateTab($module, $(this));
            });
            $tabTriggers.on('keydown.t888PetShopTabsLocal', function (event) {
                if (event.key === 'Enter' || event.key === ' ') {
                    event.preventDefault();
                    event.stopPropagation();
                    activateTab($module, $(this));
                }
            });

            buildSwiper($activeSwiper);
        });
    }

    $(document).ready(function () {
        initPetShopCarousel($(document));
    });

    $(window).on('load', function () {
        setTimeout(function () {
            initPetShopCarousel($('.t888-pet-shop-carousel-module'));
        }, 500);
    });

    $(window).on('elementor/frontend/init', function () {
        if (typeof elementorFrontend === 'undefined' || !elementorFrontend.hooks) {
            return;
        }

        elementorFrontend.hooks.addAction('frontend/element_ready/t888-pet-shop-carousel.default', function ($scope) {
            initPetShopCarousel($scope);
        });
    });
})(jQuery);
