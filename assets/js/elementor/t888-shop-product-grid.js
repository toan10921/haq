(function ($) {
    'use strict';

    var activeRequest = null;

    function getCurrentProductGrid(link) {
        var widget = link && link.closest
            ? link.closest('.elementor-widget-t888-shop-product-grid')
            : null;
        if (widget) return widget;

        var elementorDocument = link && link.closest ? link.closest('.elementor') : null;
        if (elementorDocument) {
            widget = elementorDocument.querySelector('.elementor-widget-t888-shop-product-grid');
        }

        if (widget) return widget;

        widget = document.querySelector('.elementor-widget-t888-shop-product-grid');
        if (widget) return widget;

        // Older cached Elementor markup may not contain the generated widget
        // class yet. Locate the owning Elementor element from the grid itself.
        var grid = document.querySelector('.t888-shop-results, .t888-shop-grid');
        return grid ? (grid.closest('.elementor-element') || grid.parentElement) : null;
    }

    function getAjaxUrl() {
        if (window.t888_ajax && window.t888_ajax.ajax_url) {
            return window.t888_ajax.ajax_url;
        }
        return new URL('/wp-admin/admin-ajax.php', window.location.origin).toString();
    }

    function getFilterConfig(widget) {
        var results = widget.querySelector('.t888-shop-results');
        if (results && results.dataset.filterConfig) {
            try {
                return JSON.parse(results.dataset.filterConfig);
            } catch (error) {
                // Fall through to safe defaults when old/cached markup is used.
            }
        }

        return {
            productsPerPage: Math.max(1, widget.querySelectorAll('.t888-shop-card').length || 9),
            categories: [],
            showSaleBadge: true,
            showContactButton: true,
            contactButtonText: 'Liên hệ',
            contactButtonUrl: '#',
            contactButtonExternal: false,
            contactButtonNofollow: false,
            showPagination: true
        };
    }

    function getCategory(link) {
        var targetUrl = new URL(link.href, window.location.href);
        if (link.matches('.t888-shop-categories__link')) {
            return targetUrl.searchParams.get('product_cat') || '';
        }
        return new URL(window.location.href).searchParams.get('product_cat') || '';
    }

    function getRequestedPage(link) {
        if (!link.closest('.t888-shop-pagination')) return 1;
        var targetUrl = new URL(link.href, window.location.href);
        return Math.max(1, Number(targetUrl.searchParams.get('product-page') || 1));
    }

    function updateCategoryState(category) {
        document.querySelectorAll('.t888-shop-categories__link').forEach(function (categoryLink) {
            var linkUrl = new URL(categoryLink.href, window.location.href);
            var linkCategory = linkUrl.searchParams.get('product_cat') || '';
            var isActive = linkCategory === category;
            categoryLink.classList.toggle('is-active', isActive);
            if (isActive) categoryLink.setAttribute('aria-current', 'true');
            else categoryLink.removeAttribute('aria-current');
        });
    }

    function updateToolbar(data) {
        var text = 'Showing ' + data.start + '-' + data.end + ' of ' + data.total + ' results';
        document.querySelectorAll('.t888-shop-toolbar__result').forEach(function (result) {
            result.textContent = text;
        });
    }

    function replaceResults(widget, html) {
        var parsed = new DOMParser().parseFromString(html, 'text/html');
        var incomingResults = parsed.querySelector('.t888-shop-results');
        if (!incomingResults) throw new Error('Filtered product results not found');

        var currentResults = widget.querySelector('.t888-shop-results');
        if (currentResults) {
            currentResults.replaceWith(incomingResults);
            return;
        }

        // Compatibility with the old cached template which rendered cards
        // directly without the .t888-shop-results wrapper.
        var currentContainer = widget.querySelector(':scope > .elementor-widget-container');
        if (!currentContainer) throw new Error('Product grid container not found');
        currentContainer.innerHTML = '';
        currentContainer.appendChild(incomingResults);
    }

    function loadProductGrid(link, updateHistory) {
        var currentWidget = getCurrentProductGrid(link);
        if (!currentWidget) {
            console.error('[T888 shop filter] Product grid widget was not found.');
            return;
        }

        if (activeRequest) activeRequest.abort();
        var request = new AbortController();
        activeRequest = request;
        currentWidget.classList.add('is-category-loading');

        var config = getFilterConfig(currentWidget);
        var category = getCategory(link);
        var requestedPage = getRequestedPage(link);
        var targetUrl = new URL(link.href, window.location.href);
        var formData = new FormData();
        formData.set('action', 't888_filter_shop_products');
        formData.set('category', category);
        formData.set('page', requestedPage);
        formData.set('per_page', Math.max(1, Number(config.productsPerPage || 9)));
        formData.set('orderby', targetUrl.searchParams.get('orderby') || 'menu_order');
        formData.set('page_url', targetUrl.toString());
        formData.set('config', JSON.stringify(config));

        ['min_price', 'max_price', 'product_search'].forEach(function (key) {
            var value = targetUrl.searchParams.get(key);
            if (value !== null && value !== '') formData.set(key, value);
        });

        fetch(getAjaxUrl(), {
            method: 'POST',
            credentials: 'same-origin',
            signal: request.signal,
            body: formData,
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        }).then(function (response) {
            if (!response.ok) throw new Error('Product filter request failed');
            return response.json();
        }).then(function (response) {
            if (!response.success || !response.data || !response.data.html) {
                throw new Error('Invalid product filter response');
            }

            replaceResults(currentWidget, response.data.html);
            updateCategoryState(response.data.category || '');
            updateToolbar(response.data);
            if (updateHistory !== false) {
                window.history.pushState({}, '', targetUrl.toString());
            }
        }).catch(function (error) {
            if (error.name !== 'AbortError') {
                // Keep the current page intact so the real AJAX/markup error is
                // visible in DevTools instead of being hidden by a page reload.
                console.error('[T888 shop filter]', error);
            }
        }).finally(function () {
            if (activeRequest !== request) return;
            activeRequest = null;
            currentWidget.classList.remove('is-category-loading');
        });
    }

    document.addEventListener('click', function (event) {
        var link = event.target.closest('.t888-shop-categories__link, .t888-shop-pagination a');
        if (!link || event.defaultPrevented || event.button !== 0 || event.metaKey || event.ctrlKey || event.shiftKey || event.altKey) return;

        // Category links are also used by the standalone Shop Product
        // Categories widget. Only take over navigation when a Product Grid is
        // available; otherwise let the link reload the page for List Product.
        if (!getCurrentProductGrid(link)) return;

        event.preventDefault();
        loadProductGrid(link, true);
    });

    function syncCategoryFromUrl() {
        var currentUrl = new URL(window.location.href);
        var category = currentUrl.searchParams.get('product_cat') || '';
        if (!category) return;

        var matchingLink = Array.prototype.find.call(
            document.querySelectorAll('.t888-shop-categories__link'),
            function (categoryLink) {
                return getCategory(categoryLink) === category;
            }
        );

        if (matchingLink) loadProductGrid(matchingLink, false);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', syncCategoryFromUrl);
    } else {
        syncCategoryFromUrl();
    }
})(jQuery);
