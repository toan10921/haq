(function () {
    'use strict';

    var timers = new WeakMap();
    var requests = new WeakMap();
    var requestSequence = 0;
    var composing = new WeakMap();

    function getAjaxUrl() {
        if (
            window.t888ShopSearch &&
            window.t888ShopSearch.ajaxUrl
        ) {
            return window.t888ShopSearch.ajaxUrl;
        }

        if (
            window.t888_ajax &&
            window.t888_ajax.ajax_url
        ) {
            return window.t888_ajax.ajax_url;
        }

        return new URL(
            '/wp-admin/admin-ajax.php',
            window.location.origin
        ).toString();
    }

    function getResults(root) {
        var elementorDocument = root.closest('.elementor');

        if (elementorDocument) {
            var grid = elementorDocument.querySelector(
                '.elementor-widget-t888-shop-product-grid'
            );

            if (grid) {
                var results = grid.querySelector(
                    '.t888-shop-results'
                );

                if (results) {
                    return results;
                }
            }
        }

        return document.querySelector('.t888-shop-results');
    }

    function getConfig(results) {
        if (results.dataset.filterConfig) {
            try {
                return JSON.parse(
                    results.dataset.filterConfig
                );
            } catch (error) {
                console.error(
                    '[T888 shop search] Invalid filter config.',
                    error
                );
            }
        }

        return {
            productsPerPage: Math.max(
                1,
                results.querySelectorAll('.t888-shop-card').length || 9
            ),
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

    function buildPageUrl(form, keyword) {
        var url = new URL(
            form.action || window.location.href,
            window.location.href
        );

        new FormData(form).forEach(function (value, key) {
            if (value !== '') {
                url.searchParams.set(key, value);
            } else {
                url.searchParams.delete(key);
            }
        });

        url.searchParams.delete('product-page');
        url.searchParams.delete('paged');
        url.searchParams.delete('s');
        url.searchParams.delete('post_type');

        // Quan trọng:
        // URL luôn phản ánh keyword cuối cùng
        if (keyword !== '') {
            url.searchParams.set(
                'product_search',
                keyword
            );
        } else {
            url.searchParams.delete('product_search');
        }

        return url;
    }

    function updateToolbar(data) {
        if (
            typeof data.start === 'undefined' ||
            typeof data.end === 'undefined' ||
            typeof data.total === 'undefined'
        ) {
            return;
        }

        var text =
            'Showing ' +
            data.start +
            '\u2013' +
            data.end +
            ' of ' +
            data.total +
            ' results';

        document
            .querySelectorAll('.t888-shop-toolbar__result')
            .forEach(function (result) {
                result.textContent = text;
            });
    }

    function submitNormally(form) {
        HTMLFormElement.prototype.submit.call(form);
    }

    function cancelRequest(root) {
        var request = requests.get(root);

        if (request) {
            request.controller.abort();
            requests.delete(root);
        }
    }

    function search(root, force) {
        var form = root.querySelector(
            '.t888-shop-search__form'
        );

        var input = root.querySelector(
            '.t888-shop-search__input'
        );

        var status = root.querySelector(
            '.t888-shop-search__status'
        );

        if (!form || !input) {
            return;
        }

        // Không search khi người dùng vẫn đang gõ bằng IME
        if (composing.get(root)) {
            return;
        }

        var keyword = input.value.trim();

        var minimum = Math.max(
            1,
            Number(root.dataset.minCharacters) || 1
        );

        if (
            !force &&
            keyword !== '' &&
            keyword.length < minimum
        ) {
            return;
        }

        var lastKeyword =
            root.dataset.shopSearchLastKeyword || '';

        if (!force && keyword === lastKeyword) {
            return;
        }

        var results = getResults(root);

        if (!results) {
            submitNormally(form);
            return;
        }

        // Hủy request trước
        cancelRequest(root);

        // Tạo ID riêng cho request
        var requestId = ++requestSequence;

        var controller = new AbortController();

        requests.set(root, {
            id: requestId,
            controller: controller,
            keyword: keyword
        });

        root.dataset.shopSearchLastKeyword = keyword;

        var config = getConfig(results);

        // Quan trọng: truyền keyword vào URL
        var pageUrl = buildPageUrl(
            form,
            keyword
        );

        var requestData = new FormData();

        var category =
            pageUrl.searchParams.get('product_cat') ||
            results.dataset.activeCategory ||
            '';

        requestData.set(
            'action',
            't888_filter_shop_products'
        );

        requestData.set(
            'category',
            category
        );

        requestData.set(
            'page',
            '1'
        );

        requestData.set(
            'per_page',
            Math.max(
                1,
                Number(config.productsPerPage) || 9
            )
        );

        requestData.set(
            'orderby',
            pageUrl.searchParams.get('orderby') ||
            'menu_order'
        );

        requestData.set(
            'page_url',
            pageUrl.toString()
        );

        requestData.set(
            'config',
            JSON.stringify(config)
        );

        if (keyword !== '') {
            requestData.set(
                'product_search',
                keyword
            );
        }

        [
            'min_price',
            'max_price'
        ].forEach(function (key) {
            var value =
                pageUrl.searchParams.get(key);

            if (
                value !== null &&
                value !== ''
            ) {
                requestData.set(
                    key,
                    value
                );
            }
        });

        var widget = results.closest(
            '.elementor-widget-t888-shop-product-grid, .elementor-element'
        );

        root.classList.add(
            'is-searching'
        );

        if (widget) {
            widget.classList.add(
                'is-live-searching'
            );
        }

        if (status) {
            status.textContent =
                'Searching products...';
        }

        fetch(getAjaxUrl(), {
            method: 'POST',
            credentials: 'same-origin',
            signal: controller.signal,
            body: requestData,
            headers: {
                'X-Requested-With':
                    'XMLHttpRequest'
            }
        })
        .then(function (response) {

            if (!response.ok) {
                throw new Error(
                    'Search request failed with status ' +
                    response.status
                );
            }

            return response.json();
        })
        .then(function (response) {

            /*
             * CỰC KỲ QUAN TRỌNG
             *
             * Nếu request này không còn là request mới nhất
             * thì tuyệt đối không được cập nhật DOM hoặc URL.
             */

            var current = requests.get(root);

            if (
                !current ||
                current.id !== requestId
            ) {
                return;
            }

            if (
                !response.success ||
                !response.data ||
                typeof response.data.html !== 'string'
            ) {
                throw new Error(
                    'Invalid shop search response'
                );
            }

            var parsed =
                new DOMParser()
                    .parseFromString(
                        response.data.html,
                        'text/html'
                    );

            var incomingResults =
                parsed.querySelector(
                    '.t888-shop-results'
                );

            if (!incomingResults) {
                throw new Error(
                    'Product results markup was not found'
                );
            }

            // Kiểm tra thêm một lần nữa
            // trước khi thay DOM
            current = requests.get(root);

            if (
                !current ||
                current.id !== requestId
            ) {
                return;
            }

            results.replaceWith(
                incomingResults
            );

            updateToolbar(
                response.data
            );

            /*
             * Chỉ request mới nhất được phép
             * cập nhật URL.
             */
            window.history.replaceState(
                {},
                '',
                pageUrl.toString()
            );

            if (status) {
                status.textContent =
                    'Product results updated';
            }
        })
        .catch(function (error) {

            if (
                error.name ===
                'AbortError'
            ) {
                return;
            }

            var current =
                requests.get(root);

            if (
                !current ||
                current.id !== requestId
            ) {
                return;
            }

            console.error(
                '[T888 shop search]',
                error
            );

            if (status) {
                status.textContent =
                    'Product search failed';
            }

            submitNormally(form);
        })
        .finally(function () {

            var current =
                requests.get(root);

            if (
                !current ||
                current.id !== requestId
            ) {
                return;
            }

            requests.delete(root);

            root.classList.remove(
                'is-searching'
            );

            if (widget) {
                widget.classList.remove(
                    'is-live-searching'
                );
            }
        });
    }

    /*
     * ========================================
     * COMPOSITION - HỖ TRỢ TIẾNG VIỆT
     * ========================================
     */

    document.addEventListener(
        'compositionstart',
        function (event) {

            var input =
                event.target.closest &&
                event.target.closest(
                    '.t888-shop-search__input'
                );

            if (!input) {
                return;
            }

            var root =
                input.closest(
                    '.t888-shop-search'
                );

            if (!root) {
                return;
            }

            composing.set(
                root,
                true
            );

            window.clearTimeout(
                timers.get(root)
            );
        }
    );

    document.addEventListener(
        'compositionend',
        function (event) {

            var input =
                event.target.closest &&
                event.target.closest(
                    '.t888-shop-search__input'
                );

            if (!input) {
                return;
            }

            var root =
                input.closest(
                    '.t888-shop-search'
                );

            if (!root) {
                return;
            }

            composing.set(
                root,
                false
            );

            /*
             * Chỉ bắt đầu debounce
             * sau khi bộ gõ hoàn tất.
             */
            var delay = Math.max(
                300,
                Number(root.dataset.delay) || 500
            );

            window.clearTimeout(
                timers.get(root)
            );

            timers.set(
                root,
                window.setTimeout(
                    function () {
                        search(
                            root,
                            false
                        );
                    },
                    delay
                )
            );
        }
    );

    /*
     * ========================================
     * INPUT
     * ========================================
     */

    document.addEventListener(
        'input',
        function (event) {

            var input =
                event.target.closest &&
                event.target.closest(
                    '.t888-shop-search__input'
                );

            if (!input) {
                return;
            }

            var root =
                input.closest(
                    '.t888-shop-search'
                );

            if (!root) {
                return;
            }

            if (
                root.dataset.liveSearch !==
                'yes'
            ) {
                return;
            }

            // Đang gõ tiếng Việt/IME
            if (composing.get(root)) {
                return;
            }

            window.clearTimeout(
                timers.get(root)
            );

            /*
             * 500ms sẽ mượt hơn 100ms/350ms
             * cho search sản phẩm.
             */
            var delay = Math.max(
                300,
                Number(root.dataset.delay) || 500
            );

            timers.set(
                root,
                window.setTimeout(
                    function () {
                        search(
                            root,
                            false
                        );
                    },
                    delay
                )
            );
        }
    );

    /*
     * ========================================
     * SUBMIT
     * ========================================
     */

    document.addEventListener(
        'submit',
        function (event) {

            var form =
                event.target.closest &&
                event.target.closest(
                    '.t888-shop-search__form'
                );

            if (!form) {
                return;
            }

            var root =
                form.closest(
                    '.t888-shop-search'
                );

            if (!root) {
                return;
            }

            event.preventDefault();

            window.clearTimeout(
                timers.get(root)
            );

            composing.set(
                root,
                false
            );

            search(
                root,
                true
            );
        }
    );

    /*
     * ========================================
     * INIT
     * ========================================
     */

    document
        .querySelectorAll(
            '.t888-shop-search'
        )
        .forEach(function (root) {

            root.dataset.shopSearchReady =
                'yes';

            composing.set(
                root,
                false
            );
        });

})();