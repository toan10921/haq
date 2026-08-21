(function ($) {
    'use strict';

    function readNumber(element, attribute, fallback) {
        var value = parseInt(element.getAttribute(attribute), 10);
        return Number.isFinite(value) ? value : fallback;
    }

    function getOptions(element) {
        var desktopSlides = readNumber(element, 'data-slides-desktop', 3);
        var slideCount = element.querySelectorAll('.swiper-slide').length;
        var reducedMotion = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        var autoplayEnabled = element.getAttribute('data-autoplay') === 'yes' && !reducedMotion;

        return {
            slidesPerView: readNumber(element, 'data-slides-mobile', 1),
            spaceBetween: readNumber(element, 'data-slide-gap', 30),
            speed: reducedMotion ? 0 : readNumber(element, 'data-transition-speed', 650),
            loop: element.getAttribute('data-loop') === 'yes' && slideCount > desktopSlides,
            watchOverflow: true,
            grabCursor: slideCount > desktopSlides,
            keyboard: { enabled: true, onlyInViewport: true },
            autoplay: autoplayEnabled ? {
                delay: readNumber(element, 'data-autoplay-delay', 4500),
                disableOnInteraction: false,
                pauseOnMouseEnter: true
            } : false,
            navigation: {
                prevEl: element.querySelector('.category-showcase-nav--prev'),
                nextEl: element.querySelector('.category-showcase-nav--next')
            },
            breakpoints: {
                768: { slidesPerView: readNumber(element, 'data-slides-tablet', 2) },
                1200: { slidesPerView: desktopSlides }
            },
            observer: true,
            observeParents: true,
            a11y: { enabled: true }
        };
    }

    function initialize(element) {
        if (!element || element.dataset.t888CategorySliderReady === 'true') {
            return;
        }

        element.dataset.t888CategorySliderReady = 'true';
        var options = getOptions(element);

        if (typeof window.Swiper === 'function') {
            element.t888CategorySwiper = new window.Swiper(element, options);
            return;
        }

        if (window.elementorFrontend && elementorFrontend.utils && elementorFrontend.utils.swiper) {
            new elementorFrontend.utils.swiper($(element), options).then(function (instance) {
                element.t888CategorySwiper = instance;
            }).catch(function () {
                element.dataset.t888CategorySliderReady = 'false';
            });
            return;
        }

        element.dataset.t888CategorySliderReady = 'false';
    }

    function initializeInScope(scope) {
        var root = scope && scope.jquery ? scope[0] : scope;
        root = root || document;

        if (root.matches && root.matches('[data-t888-category-slider]')) {
            initialize(root);
        }

        if (root.querySelectorAll) {
            Array.prototype.forEach.call(root.querySelectorAll('[data-t888-category-slider]'), initialize);
        }
    }

    $(function () {
        initializeInScope(document);
    });

    $(window).on('elementor/frontend/init', function () {
        if (window.elementorFrontend && window.elementorFrontend.hooks) {
            window.elementorFrontend.hooks.addAction(
                'frontend/element_ready/t888-featured-categories.default',
                initializeInScope
            );
        }
    });
})(jQuery);
