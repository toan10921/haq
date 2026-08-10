jQuery(function ($) {
    $('.t888-vertical-menu--style4').each(function () {
        var $menu = $(this);
        var isHomeExpanded = $menu.attr('data-home-expanded') === 'yes';
        var triggerMode = $menu.attr('data-expand-trigger') || 'hover';
        var $header = $menu.find('.t888-vertical-menu__header').first();
        var $body = $menu.find('.t888-vertical-menu__body').first();
        var $items = $menu.find('.t888-vertical-menu__list > li');

        function syncState(open) {
            $menu.toggleClass('is-open', open);
            $header.attr('aria-expanded', open ? 'true' : 'false');
            $body.attr('aria-hidden', open ? 'false' : 'true');
        }

        function alignFlyout($item) {
            var $panel = $item.children('.sub-menu, .mega-menu');

            if (!$panel.length) {
                return;
            }

            var bodyRect = $body[0].getBoundingClientRect();
            var itemRect = $item[0].getBoundingClientRect();
            var offsetTop = itemRect.top - bodyRect.top;

            $panel.css('top', offsetTop > 0 ? (-offsetTop) + 'px' : '0px');
        }

        function bindFlyoutAlignment() {
            $items.each(function () {
                var $item = $(this);

                if (!$item.children('.sub-menu, .mega-menu').length) {
                    return;
                }

                $item.on('mouseenter focusin', function () {
                    alignFlyout($item);
                });
            });

            $(window).on('resize', function () {
                var $activeItem = $items.filter(':hover').first();

                if ($activeItem.length) {
                    alignFlyout($activeItem);
                }
            });
        }

        bindFlyoutAlignment();

        if (isHomeExpanded) {
            syncState(true);
            return;
        }

        syncState(false);

        if (triggerMode === 'click') {
            $header.on('click', function (e) {
                e.preventDefault();
                syncState(!$menu.hasClass('is-open'));
            });

            $(document).on('click', function (e) {
                if (!$(e.target).closest($menu).length) {
                    syncState(false);
                }
            });

            $(document).on('keydown', function (e) {
                if (e.key === 'Escape') {
                    syncState(false);
                }
            });
        } else {
            $menu.on('mouseenter', function () {
                syncState(true);
            });

            $menu.on('mouseleave', function () {
                syncState(false);
            });
        }
    });

    function openMenu() {
        $('.mobile-menu-wrapper').addClass('open').attr('aria-hidden', 'false');
        $('body').addClass('mobile-menu-open');
    }
    function closeMenu() {
        $('.mobile-menu-wrapper').removeClass('open').attr('aria-hidden', 'true');
        $('body').removeClass('mobile-menu-open');
    }

    $('.menu-toggle-mobile').on('click', openMenu);
    $('.mobile-menu-close, .mobile-menu-overlay').on('click', closeMenu);
    $(document).on('click', function (e) {
        if ($('.mobile-menu-wrapper').hasClass('open') &&
            !$(e.target).closest('.mobile-menu-wrapper, .menu-toggle-mobile').length) {
            closeMenu();
        }
    });

    $('.mobile-menu-list li').has('> .sub-menu, > .mega-menu').each(function () {
        var $a = $(this).children('a');

        if ($a.attr('href') === '#' || !$a.attr('href')) {
            $a.attr('href', 'javascript:void(0)');
        }

        if (!$a.find('.toggle-submenu').length) {
            $a.append('<span class="toggle-submenu" aria-expanded="false"><i class="las la-angle-down"></i></span>');
        }

        $(this).children('.sub-menu, .mega-menu')
            .attr('aria-hidden', 'true')
            .css({ maxHeight: 0, visibility: 'hidden' });
    });

    function setPanelState($li, open) {
        var $panel = $li.children('.sub-menu, .mega-menu');
        var $btn = $li.children('a').find('.toggle-submenu');

        if (open) {
            var h = $panel.prop('scrollHeight');
            $panel.css({ visibility: 'visible', maxHeight: h + 'px' }).attr('aria-hidden', 'false');
            $li.addClass('open');
            $btn.attr('aria-expanded', 'true');
        } else {
            $panel.css({ maxHeight: 0 }).attr('aria-hidden', 'true');
            $panel.one('transitionend', function () {
                if (!$li.hasClass('open')) $(this).css('visibility', 'hidden');
            });
            $li.removeClass('open');
            $btn.attr('aria-expanded', 'false');
        }
    }


    $('.mobile-menu-list').on('click', '.toggle-submenu', function (e) {
        e.preventDefault();
        e.stopPropagation();

        var $li = $(this).closest('li');
        var open = $li.hasClass('open');

        setPanelState($li, !open);
    });

});
