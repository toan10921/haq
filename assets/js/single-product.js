jQuery(document).ready(function ($) {
    window._detailGalleryMode = null;
    function adjustThumbHeight() {
        var galleryHeight = $(".main-gallery-wrapper .main-gallery").outerHeight();
        var spacing = 35; // minus 40px for spacing
        if (window.innerWidth < 1599) {
            spacing = 32;
        }
        var newHeight = galleryHeight - spacing;
        if (!$(".gallery-thumbs-wrapper .swiper-wrapper").length) {
            return;
        }
        $(".gallery-thumbs-wrapper .swiper-wrapper").css("height", newHeight + "px");
    }


    let _swThumb = null, _swMain = null, _mode = null;
    const THUMB = '.detail-vertical-swiper-slider';
    const MAIN = '.main-gallery';

    function _isMobile() { return window.matchMedia('(max-width: 767px)').matches; }

    function _destroySwipers() {
        if (_swMain) { _swMain.destroy(true, true); _swMain = null; }
        if (_swThumb) { _swThumb.destroy(true, true); _swThumb = null; }

        $(document).off('click.thumb');
    }

    function handleInitSwiperGallery() {
        if (!$(THUMB).length) return;

        const $el = $(THUMB).first();
        const perview_destop = +($el.attr('data-perviewdestop') || 3);
        const perview_table = +($el.attr('data-perviewtable') || 3);
        const perview_mobi = +($el.attr('data-perviewmobi') || 3);
        const spacebetween = +($el.attr('data-spacebetween') || 0);
        const navAttr = $el.attr('data-navigation');
        const navigation = (navAttr === 'true') ? {
            nextEl: '.swiper-button-wraper .swiper-button-next',
            prevEl: '.swiper-button-wraper .swiper-button-prev',
        } : undefined;

        const newMode = _isMobile() ? 'h' : 'v';

        if (newMode !== _mode) {
            _destroySwipers();

            _swThumb = new Swiper($el[0], {
                direction: (newMode === 'h') ? 'horizontal' : 'vertical',
                slidesPerView: (newMode === 'h') ? perview_mobi : perview_destop,
                spaceBetween: (newMode === 'h') ? 0 : spacebetween,
                breakpoints: {
                    0: { slidesPerView: perview_mobi, spaceBetween: 0 },
                    767: { slidesPerView: perview_table, spaceBetween: 0 },
                    1170: { slidesPerView: perview_destop, spaceBetween: spacebetween }
                },
                navigation,
                loop: false,
                watchSlidesVisibility: true,
                watchSlidesProgress: true,
                watchOverflow: true,
                observer: true, observeParents: true, resizeObserver: true
            });

            _swMain = new Swiper(MAIN, {
                slidesPerView: 1,
                spaceBetween: 0,
                loop: false,
                navigation: {
                    nextEl: `${MAIN} .swiper-button-next`,
                    prevEl: `${MAIN} .swiper-button-prev`,
                },
                thumbs: { swiper: _swThumb },
                observer: true, observeParents: true, resizeObserver: true
            });


            $(document).on('click.thumb', `${THUMB} .swiper-slide`, function () {
                const idx = $(this).index();
                _swMain && _swMain.slideTo(idx, 0);
                const $root = $(this).closest(THUMB);
                $root.find('.swiper-slide').removeClass('thumb-active');
                $(this).addClass('thumb-active');
            });

            _mode = newMode;
            setTimeout(adjustThumbHeight, 0);
            return;
        }

        _swThumb && _swThumb.update();
        _swMain && _swMain.update();
        setTimeout(adjustThumbHeight, 0);
    }


    function handleStickyAddToCartVisibility() {
        var $sticky = $('.sticky-add-to-cart');
        var $form = $('form.cart');

        if (!$sticky.length || !$form.length) return;

        var rect = $form[0].getBoundingClientRect();
        if (rect.bottom < 0) {
            $sticky.fadeIn(150);
        } else {
            $sticky.fadeOut(150);
        }
    }

    function initAccordionProductTabs() {
        jQuery(function ($) {
            const $accordionWrapper = $('.woocommerce-tabs.accordion-tabs');

            if (!$accordionWrapper.length) return;

            $accordionWrapper.find('.accordion-tab-title').each(function () {
                const $title = $(this);
                const $content = $title.next('.accordion-tab-content');
                const $icon = $title.find('.accordion-toggle-icon i');

                $title.attr('aria-expanded', 'false');
                $content.css({ maxHeight: 0 });
                $icon.removeClass('la-minus').addClass('la-plus');

                $title.off('click').on('click', function () {
                    const isActive = $title.attr('aria-expanded') === 'true';

                    $accordionWrapper.find('.accordion-tab-title').attr('aria-expanded', 'false');
                    $accordionWrapper.find('.accordion-tab-content').css({ maxHeight: 0 });
                    $accordionWrapper.find('.accordion-toggle-icon i')
                        .removeClass('la-minus')
                        .addClass('la-plus');

                    if (!isActive) {
                        $title.attr('aria-expanded', 'true');
                        $icon.removeClass('la-plus').addClass('la-minus');
                        const scrollHeight = $content.get(0).scrollHeight;
                        $content.css({ maxHeight: scrollHeight + 'px' });
                    }
                });
            });

            const $first = $accordionWrapper.find('.accordion-tab-title').first();
            if ($first.length) $first.trigger('click');
        });
    }

    function initScrollFollowByTop() {
        const $ = jQuery;

        const $modalRoot = $('.quick-view-wrap .fancybox__content:visible').last();
        const $root = $modalRoot.length ? $modalRoot : $(document);
        const $scroll = $('.fancybox__slide.is-selected:visible').last().length ? $('.fancybox__slide.is-selected:visible').last() : $(window);

        let $info = $root.find('.sticky-layout .detail-info');
        let $wrapper = $root.find('.sticky-layout');
        let $gallery = $root.find('#sticky-gallery, .sticky-gallery');
        if (!$info.length || !$wrapper.length || !$gallery.length) {
            $info = $('.sticky-layout .detail-info');
            $wrapper = $('.sticky-layout');
            $gallery = $('#sticky-gallery, .sticky-gallery');
        }
        if (!$info.length || !$wrapper.length || !$gallery.length) return;

        const isQuickview = $modalRoot.length > 0;

        const dataOffset = parseFloat($wrapper.attr('data-sticky-offset'));
        const hasDataOffset = !isNaN(dataOffset);

        const slideEl = $scroll[0] !== window ? $scroll[0] : null;
        const slidePadTop = slideEl ? parseFloat(getComputedStyle(slideEl).paddingTop || '0') : 0;

        const adminBarH = $('#wpadminbar').length ? $('#wpadminbar').outerHeight() : 0;


        const baseDefault = isQuickview ? 0 : 200;

        const offsetTop = (hasDataOffset ? dataOffset : baseDefault) + slidePadTop + adminBarH;


        let ticking = false;

        function getScrollTop() {
            return ($scroll[0] === window) ? (window.scrollY || window.pageYOffset) : $scroll.scrollTop();
        }
        function relTop($el) {
            if ($scroll[0] === window) return $el.offset().top;
            const cont = $scroll[0];
            const er = $el[0].getBoundingClientRect();
            const cr = cont.getBoundingClientRect();
            return (er.top - cr.top) + $scroll.scrollTop();
        }

        function updateScrollFollow() {
            const isDesktop = ($scroll[0] === window ? window.innerWidth : $scroll.innerWidth()) > 768;
            if (!isDesktop || !$info.is(':visible')) { $info.css({ transform: '' }); ticking = false; return; }

            const scrollTop = getScrollTop();
            const wrapperTop = relTop($wrapper);
            const galleryTop = relTop($gallery);
            const galleryHeight = $gallery.outerHeight();
            const infoHeight = $info.outerHeight();
            if (!galleryHeight || !infoHeight) { ticking = false; return; }

            const stopPoint = galleryTop + galleryHeight - infoHeight - offsetTop;

            let newTop = 0;
            if (scrollTop > wrapperTop - offsetTop && scrollTop < stopPoint) {
                newTop = scrollTop - wrapperTop + offsetTop;
            } else if (scrollTop >= stopPoint) {
                newTop = galleryHeight - infoHeight;
            }

            newTop = Math.max(0, Math.min(newTop, Math.max(0, galleryHeight - infoHeight)));

            $info.css({ transform: `translateY(${Math.round(newTop)}px)` });
            ticking = false;
        }

        function onScrollOrResize() {
            if (!ticking) { window.requestAnimationFrame(updateScrollFollow); ticking = true; }
        }

        $(window).off('.scrollFollow');
        $('.fancybox__slide').off('.scrollFollow');
        const ns = '.scrollFollow';
        $scroll.on('scroll' + ns + ' resize' + ns, onScrollOrResize);

        setTimeout(updateScrollFollow, 0);
        $root.find('img').off('load' + ns).on('load' + ns, () => requestAnimationFrame(updateScrollFollow));
    }





    initScrollFollowByTop();
    adjustThumbHeight();
    handleInitSwiperGallery();
    handleStickyAddToCartVisibility();
    initAccordionProductTabs();

    $(window).on('resize', function () {
        setTimeout(function () {
            handleInitSwiperGallery();
            // handleInitSwiperGallery();
        }, 500);
    });

    $(window).on('t888f_quickview_loaded', function () {
        setTimeout(function () {
            handleInitSwiperGallery();
            adjustThumbHeight();
            initScrollFollowByTop();
        }, 500);
    });

    $(document).on('scroll', handleStickyAddToCartVisibility);
});

