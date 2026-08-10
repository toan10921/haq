(function ($) {
  function initReveal($ctx) {
    var $root = $ctx && $ctx.length ? $ctx : $(document);
    var $targets = $root
      .find('.reveal-left, .reveal-right, .reveal-up, .t888-year-vertical, .t888-quote-logos')
      .filter(':not(.reveal-inited)');

    $targets.addClass('reveal-inited');

    if ('IntersectionObserver' in window) {
      var io = new IntersectionObserver(function (entries) {
        entries.forEach(function (entry) {
          if (entry.isIntersecting) {
            $(entry.target).addClass('in-view');
            io.unobserve(entry.target);
          }
        });
      }, { rootMargin: '0px 0px -10% 0px', threshold: 0.2 });

      $targets.each(function () { io.observe(this); });
    } else {

      $targets.addClass('in-view');
    }
  }
  $(function () { initReveal(); });
  $(window).on('elementor/frontend/init', function () {
    elementorFrontend.hooks.addAction(
      'frontend/element_ready/t888-quote-box.default',
      function ($scope) { initReveal($scope); }
    );
  });
  $(document).on('shop_ajax_content_loaded t888_shop_filtered', function (e, res) {
    initReveal($(document));
  });

})(jQuery);