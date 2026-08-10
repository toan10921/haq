jQuery(function ($) {
  Fancybox.bind("[data-fancybox]", {});

  function initAboutInview(root) {
    var ctx   = (root && root.nodeType) ? root : document;
    var nodes = ctx.querySelectorAll('.t888-about-box:not([data-inview-watch])');
    if (!nodes.length) return;

    var isEdit = window.elementorFrontend && elementorFrontend.isEditMode && elementorFrontend.isEditMode();
    if (isEdit) {
      nodes.forEach(function (el) {
        el.classList.add('is-inview');
        el.setAttribute('data-inview-watch', '');
      });
      return;
    }

    if (!('IntersectionObserver' in window)) {
      nodes.forEach(function (el) {
        el.classList.add('is-inview');
        el.setAttribute('data-inview-watch', '');
      });
      return;
    }

    var io = new IntersectionObserver(function (entries, obs) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          entry.target.classList.add('is-inview');
          obs.unobserve(entry.target);
        }
      });
    }, {
      root: null,
      rootMargin: '0px 0px -10% 0px',
      threshold: 0.15
    });

    nodes.forEach(function (el) {
      el.setAttribute('data-inview-watch', '');
      io.observe(el);
    });
  }

  // Frontend load
  initAboutInview(document);

  if (window.elementorFrontend) {
    $(window).on('elementor/frontend/init', function () {
      elementorFrontend.hooks.addAction('frontend/element_ready/t888-about-us.default', function ($scope) {
        initAboutInview($scope[0] || document);
      });
      elementorFrontend.hooks.addAction('frontend/element_ready/global', function ($scope) {
        initAboutInview($scope[0] || document);
      });
    });
  }
});
