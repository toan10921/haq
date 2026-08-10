/** 
 * This function initializes the ajax filters on the page.
 * This function is called when the page is loaded.
 * This function will also set up event listeners for filter changes.
 * This function will be triggered by user interactions with the filters.
 */

jQuery(document).ready(function ($) {
    function fetchShopContent(url, resetPage = false) {
        const wrapper = '#products-ajax-wrapper';
        if (!$(wrapper).length) return;

        const ajaxUrl = new URL(url, window.location.origin);
        if (resetPage) {
            ajaxUrl.searchParams.set('paged', 1);
        }

        $('body').addClass('loading');
        $(wrapper).fadeTo(200, 0.3);

        $.get(ajaxUrl.toString(), function (response) {
            const newContent = $(response).find(wrapper).html();
            $(wrapper).html(newContent).fadeTo(200, 1);

            if (history.pushState) {
                history.pushState(null, '', ajaxUrl.toString());
            }
            // trigger new event for this action
            $(document).trigger('shop_ajax_content_loaded', [response, ajaxUrl]);
            initAllFilters();
        }).fail(function (xhr) {
            $(wrapper).fadeTo(200, 1).html('<div class="ajax-error">Error when fetching data. Please try again.</div>');
            console.warn('[AJAX] Failed to load:', ajaxUrl.toString());
            console.warn(xhr.responseText);
        }).always(function () {
            $('body').removeClass('loading');
        });
    }

    function getBaseParams() {
        const url = new URL(window.location.href);
        const params = new URLSearchParams(url.search);

        const getFromHref = (selector, key) => {
            const href = $(selector).filter('.active').attr('href');
            if (href) {
                const value = new URL(href, window.location.origin).searchParams.get(key);
                if (value) params.set(key, value);
            }
        };

        getFromHref('.view-style a', 'view');
        getFromHref('.show-per-page a', 'posts_per_page');

        let orderby = $('#custom-orderby-input').val();
        if (!orderby || orderby === '') {
            const urlParam = new URL(window.location.href).searchParams.get('orderby');
            orderby = urlParam || 'date';
            $('#custom-orderby-input').val(orderby);
        }
        params.set('orderby', orderby);


        const min = $('#price-min').val();
        const max = $('#price-max').val();
        if (min) params.set('min_price', min);
        if (max) params.set('max_price', max);

        const brand = $(".brand-filter-checkbox:checked").map(function () {
            return $(this).val();
        }).get();
        if (brand.length) params.set('brand', brand.join(','))
        else params.delete('brand');

        const cat = new URLSearchParams(window.location.search).get('product_cat');
        if (cat) params.set('product_cat', cat);

        return { url, params };
    }

    function initCustomOrderByDropdown() {
        // Toggle dropdown
        $('body').off('click.orderDropdown').on('click.orderDropdown', '.custom-dropdown-toggle', function (e) {
            e.preventDefault();
            $(this).next('.custom-dropdown-menu').slideToggle(150);
        });

        // select item
        $('body').off('click.orderSelect').on('click.orderSelect', '.custom-dropdown-menu li', function (e) {
            e.stopPropagation();
            e.preventDefault();

            const value = $(this).data('value');
            const label = $(this).text();

            $(this).addClass('selected').siblings().removeClass('selected');
            $(this).closest('.custom-dropdown').find('.custom-dropdown-toggle').text(label);
            $('#custom-orderby-input').val(value);

            const { url, params } = getBaseParams();
            params.set('orderby', value);
            params.set('paged', 1);

            fetchShopContent(`${url.origin}${url.pathname}?${params.toString()}`, true);

            // close dropdown after selection
            $(this).closest('.custom-dropdown-menu').slideUp(150);
        });

        // Set label and select class on initial load
        const defaultVal = $('#custom-orderby-input').val() || 'date';
        const $selectedLi = $(`.custom-dropdown-menu li[data-value="${defaultVal}"]`);
        if ($selectedLi.length) {
            $('.custom-dropdown-toggle').text($selectedLi.text());
            $selectedLi.addClass('selected');
        }
    }

    function initPriceSlider() {
        const minInput = $('#price-min');
        const maxInput = $('#price-max');
        const maxLimit = parseInt($('#price-max-limit').val() || 1000);
        const minValue = $('#price-min-value');
        const maxValue = $('#price-max-value');
        const currentMin = parseInt(minInput.val() || 0);
        const currentMax = parseInt(maxInput.val() || maxLimit);

        if ($('#price-range').length) {
            $('#price-range').slider({
                range: true,
                min: 0,
                max: maxLimit,
                values: [currentMin, currentMax],
                slide: function (event, ui) {
                    minValue.text(ui.values[0]);
                    maxValue.text(ui.values[1]);
                    minInput.val(ui.values[0]);
                    maxInput.val(ui.values[1]);
                }
            });
        }
    }

    function initPriceFilter() {
        $('body').off('click.priceFilter').on('click.priceFilter', '#apply-price-filter', function (e) {
            e.preventDefault();
            const { url, params } = getBaseParams();
            fetchShopContent(`${url.origin}${url.pathname}?${params.toString()}`, true);
        });
    }

    function initBrandFilter() {


        $('body').off('change.brandFilter').on('change.brandFilter', '.brand-filter-checkbox', function () {
            const { url, params } = getBaseParams();
            fetchShopContent(`${url.origin}${url.pathname}?${params.toString()}`, true);
        });

        $('body').off('click.brand-name-link').on('click.brand-name-link', '.brand-name-link', function (e) {
            e.preventDefault();
            let checkbox = $(this).closest('li').find('.brand-filter-checkbox');
            checkbox.prop('checked', !checkbox.prop('checked'));
            checkbox.trigger('change.brandFilter');

        });


    }

    function initAttributeFilters() {
        $('body').off('click.attributeFilter').on('click.attributeFilter', '.custom-filter-attribute a', function (e) {
            e.preventDefault();

            const $link = $(this);
            const $li = $link.closest('li');
            const href = $link.attr('href');
            const currentUrl = new URL(window.location.href);
            const currentParams = new URLSearchParams(currentUrl.search);

            let paramKey = $li.data('param_key') || null;
            let paramValue = $li.data('param_value') || null;

            if (!paramKey || !paramValue) {
                console.warn('Attribute filter missing key or value:', $li);
                return;
            }
            let values = currentParams.get(paramKey)?.split(',') || [];
            if ($li.hasClass('selected')) {
                values = values.filter(v => v !== paramValue);
                $li.removeClass('selected');
                $link.find('.icon-selected').remove();
            } else {
                if (!values.includes(paramValue)) {
                    values.push(paramValue);
                }
                $li.addClass('selected');
                if ($link.closest('.filter-color-list').length && !$link.find('.icon-selected').length) {
                    $link.append('<i class="las la-angle-up icon-selected"></i>');
                }
            }
            if (values.length) {
                currentParams.set(paramKey, [...new Set(values)].join(','));
            } else {
                currentParams.delete(paramKey);
            }

            const { url, params } = getBaseParams();

            for (const [k, v] of currentParams.entries()) {
                params.set(k, v);
            }
            // fix for removing empty params
            if (currentParams.getAll(paramKey).length === 0) {
                params.delete(paramKey);
            }
            fetchShopContent(`${url.origin}${url.pathname}?${params.toString()}`, true);
        });
    }

    function initCategoryFilter() {
        $('body').off('click.categoryFilter').on('click.categoryFilter', '.wc-block-product-categories-list-item > a', function (e) {
            e.preventDefault();
            const categoryUrl = new URL($(this).attr('href'));
            let $li = $(this).closest('li');
            let categorySlug = '';
            if (categoryUrl.searchParams.get('product_cat') !== null) {
                // If it's a query parameter, we need to get the category slug from the URL
                categorySlug = categoryUrl.searchParams.get('product_cat');
                if (!categorySlug) {
                    console.warn('No category slug found in URL:', categoryUrl);
                    return;
                }
            } else {
                categorySlug = categoryUrl.pathname.split('/').filter(Boolean).pop();
            }

            const { url, params } = getBaseParams();

            if ($li.hasClass('current-cat')) {
                params.delete('product_cat');
            
                // click to remove category filter
                if (!$('.shop-page').length) {
                    url.pathname = $('body').data('current_pathname') || '/shop/';
                }else{
                    params.delete('product_cat');
                }
                    $li.removeClass('current-cat');
            } else {
                // fix for product archive categories
                $li.closest('.wc-block-product-categories-list, .product-categories').find('.current-cat').removeClass('current-cat');
                $li.addClass('current-cat');
                // Remove 'current-cat' class from all siblings
                if (!$('.shop-page').length) {
                    url.pathname = categoryUrl.pathname;
                } else {
                    params.set('product_cat', categorySlug);
                }
            }

            fetchShopContent(`${url.origin}${url.pathname}?${params.toString()}`, true);
        });
    }

    function initShopAjax() {
        $('body').on('click', '.pagi-nav.style2 a.page-numbers, .view-style a, .show-per-page a', function (e) {
            e.preventDefault();
            const href = $(this).attr('href');
            if (href) fetchShopContent(href, false);
        });
    }

    function initAllFilters() {
        if (!$('#products-ajax-wrapper').length) return;
        if ($('.elementor-widget-t888-list-product').length > 0) {
            $('body').attr('data-current_pathname', window.location.pathname);
        }
        initCustomOrderByDropdown();
        initPriceSlider();
        initPriceFilter();
        initBrandFilter();
        initAttributeFilters();
        initCategoryFilter();
        initShopAjax();
    }

    initAllFilters();
});