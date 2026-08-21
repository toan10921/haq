(function () {
    'use strict';

    function initServiceTabs(scope) {
        var roots = [];

        if (scope && scope.matches && scope.matches('[data-t888-service-tabs]')) {
            roots.push(scope);
        }

        if (scope && scope.querySelectorAll) {
            roots = roots.concat(Array.prototype.slice.call(scope.querySelectorAll('[data-t888-service-tabs]')));
        }

        roots.forEach(function (root) {
            if (root.dataset.t888TabsReady === 'true') {
                return;
            }

            root.dataset.t888TabsReady = 'true';

            var tabs = Array.prototype.slice.call(root.querySelectorAll('[role="tab"]'));
            var panels = Array.prototype.slice.call(root.querySelectorAll('[role="tabpanel"]'));

            function activateTab(nextTab, moveFocus) {
                var panelId = nextTab.getAttribute('aria-controls');

                tabs.forEach(function (tab) {
                    var active = tab === nextTab;
                    tab.classList.toggle('is-active', active);
                    tab.setAttribute('aria-selected', active ? 'true' : 'false');
                    tab.setAttribute('tabindex', active ? '0' : '-1');
                });

                panels.forEach(function (panel) {
                    var active = panel.id === panelId;
                    panel.classList.toggle('is-active', active);
                    panel.hidden = !active;
                });

                if (moveFocus) {
                    nextTab.focus();
                }
            }

            tabs.forEach(function (tab, index) {
                tab.addEventListener('click', function () {
                    activateTab(tab, false);
                });

                tab.addEventListener('keydown', function (event) {
                    var nextIndex = index;

                    if (event.key === 'ArrowDown' || event.key === 'ArrowRight') {
                        nextIndex = (index + 1) % tabs.length;
                    } else if (event.key === 'ArrowUp' || event.key === 'ArrowLeft') {
                        nextIndex = (index - 1 + tabs.length) % tabs.length;
                    } else if (event.key === 'Home') {
                        nextIndex = 0;
                    } else if (event.key === 'End') {
                        nextIndex = tabs.length - 1;
                    } else {
                        return;
                    }

                    event.preventDefault();
                    activateTab(tabs[nextIndex], true);
                });
            });
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        initServiceTabs(document);
    });

    if (window.jQuery) {
        window.jQuery(window).on('elementor/frontend/init', function () {
            if (window.elementorFrontend && window.elementorFrontend.hooks) {
                window.elementorFrontend.hooks.addAction(
                    'frontend/element_ready/t888-service-tabs.default',
                    function (scope) {
                        initServiceTabs(scope && scope[0] ? scope[0] : scope);
                    }
                );
            }
        });
    }
})();
