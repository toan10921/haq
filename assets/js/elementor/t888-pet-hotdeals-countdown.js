(function ($) {
  function initCountdown($scope) {
    $scope.find('.t888-hotdeals-countdown').each(function () {
      var $countdown = $(this);
      var oldTimer = $countdown.data('t888Timer');

      if (oldTimer) {
        clearInterval(oldTimer);
        $countdown.removeData('t888Timer');
      }

      var deadline = parseInt($countdown.attr('data-deadline'), 10);
      if (!deadline || isNaN(deadline)) {
        return;
      }

      var loopMs = parseInt($countdown.attr('data-loop-ms'), 10) || 0;

      function update() {
        var now = Date.now();
        var distance = deadline - now;

        if (distance <= 0) {
          if (loopMs > 0) {
            var loopsPassed = Math.floor((now - deadline) / loopMs) + 1;
            deadline = deadline + loopsPassed * loopMs;
            distance = deadline - now;
          } else {
            distance = 0;
          }
        }

        var days = Math.floor(distance / 86400000);
        var hours = Math.floor((distance % 86400000) / 3600000);
        var minutes = Math.floor((distance % 3600000) / 60000);
        var seconds = Math.floor((distance % 60000) / 1000);

        $countdown.find('.days').text(String(days).padStart(2, '0'));
        $countdown.find('.hours').text(String(hours).padStart(2, '0'));
        $countdown.find('.mins').text(String(minutes).padStart(2, '0'));
        $countdown.find('.secs').text(String(seconds).padStart(2, '0'));
      }

      update();
      $countdown.data('t888Timer', setInterval(update, 1000));
    });
  }

  $(function () {
    initCountdown($(document));
  });

  $(window).on('elementor/frontend/init', function () {
    if (typeof elementorFrontend === 'undefined' || !elementorFrontend.hooks) {
      return;
    }

    elementorFrontend.hooks.addAction(
      'frontend/element_ready/t888-pet-hotdeals-countdown.default',
      initCountdown
    );
  });
})(jQuery);

