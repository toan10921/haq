jQuery(document).ready(function ($) {

    function lazyLoadBackgroundImages() {
        var $swiperEl = $('.swiper-feature-products');
        $swiperEl.find('.swiper-slide').each(function () {
            var $slide = $(this);
            var bgUrl = $slide.data('bg');
            let img = new Image();
            img.src = bgUrl;
        });
    }

    function initFeatureProductSwiper() {
        var $swiperEl = $('.swiper-feature-products');
        if ($swiperEl.length && $swiperEl[0].swiper) {
            $swiperEl[0].swiper.destroy(true, true);
        }

        try {
            var swiper = new Swiper($swiperEl[0], {
                loop: $swiperEl.data('loop') === true || $swiperEl.data('loop') === 'true',
                effect: $swiperEl.data('effect') || 'slide',
                rtl: $('html').attr('dir') === 'rtl',
                navigation: {
                    nextEl: $swiperEl.find('.swiper-button-next')[0],
                    prevEl: $swiperEl.find('.swiper-button-prev')[0]
                },
                pagination: $swiperEl.data('pagination') ? JSON.parse($swiperEl.attr('data-pagination')) : false,
            });

            function updateInfo() {
                $wrapperEl = $('.t888-feature-products-wrapper');
                var $activeSlide = $(swiper.slides).filter('[data-swiper-slide-index="' + swiper.realIndex + '"]');
                var title = $activeSlide.data('title') || '';
                var descFull = $activeSlide.data('desc') || '';
                var desc = descFull.split(' ').slice(0, 14).join(' ');
                if (descFull.split(' ').length > 18) desc += '...';

                var bgUrl = $activeSlide.data('bg') || '';
                $('#feature-product-title').text(title);
                $('#feature-product-desc').text(desc);

                if (bgUrl) {
                    $wrapperEl.css('background-image', 'url(' + bgUrl + ')');
                }
            }
            lazyLoadBackgroundImages();
            swiper.on('slideChange', updateInfo);
            setTimeout(updateInfo, 50);

        } catch (e) {
            console.warn('Swiper init error:', e);
        }
    }


    if ($('.elementor-editor-active').length) {
        // editor mode
        function waitForAllElements(selector, callback) {
            // Set store all elements that have been handled
            const handledElements = new Set();

            function checkElements() {
                const elements = document.querySelectorAll(selector);
                elements.forEach(el => {
                    if (!handledElements.has(el)) {
                        handledElements.add(el);
                        callback(el);
                    }
                });
            }

            // check imediatly first timetime
            checkElements();

            // Create a MutationObserver to watch for changes in the DOM
            const observer = new MutationObserver(() => {
                checkElements();
            });

            observer.observe(document.body, {
                childList: true,
                subtree: true,
            });
        }

        // call in editor mode
        if (typeof elementorFrontend !== 'undefined' && elementorFrontend.isEditMode()) {
            waitForAllElements('.swiper-feature-products', function (el) {
                initFeatureProductSwiper();
            });
        }
    } else {
        // frontend mode

        $(window).on('elementor/frontend/init', function () {
            if (window.elementorFrontend) {
                initFeatureProductSwiper();
            }
        });
    }

    window.reInitFeatureProductSwiper = initFeatureProductSwiper;

    $(window).on('load', function () {
        setTimeout(function () {
            initFeatureProductSwiper();
            lazyLoadBackgroundImages();
        }, 500);
    });


});
