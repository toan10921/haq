jQuery(document).ready(function ($) {
    $('.hotdeal-countdown').each(function () {
        const $countdown = $(this);
        const deadline = parseInt($countdown.data('deadline'), 10);
        if (!deadline) return;

        function updateCountdown() {
            const now = Date.now();
            const distance = deadline - now;

            if (distance <= 0) {
                $countdown.find('.countdown-hours').text("00");
                $countdown.find('.countdown-mins').text("00");
                $countdown.find('.countdown-secs').text("00");
                return;
            }

            const hours = Math.floor(distance / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            $countdown.find('.countdown-hours').text(hours.toString().padStart(2, '0'));
            $countdown.find('.countdown-mins').text(minutes.toString().padStart(2, '0'));
            $countdown.find('.countdown-secs').text(seconds.toString().padStart(2, '0'));
        }

        updateCountdown();
        setInterval(updateCountdown, 1000);
    });
});


(function ($) {
  const DAY = 86400000, HOUR = 3600000, MIN = 60000, SEC = 1000;

  function initCountdown($scope) {
    $scope.find('.hot-deals-countdown').each(function () {
      const $cd = $(this);

      const oldTimer = $cd.data('t888Timer');
      if (oldTimer) { clearInterval(oldTimer); $cd.removeData('t888Timer'); }

      let deadline = parseInt($cd.data('deadline'), 10); // ms
      if (!deadline || isNaN(deadline)) return;

      const loopDays = parseInt($cd.data('loop-days'), 10) || 0;
      const loopMs   = loopDays > 0 ? loopDays * DAY : 0;

      const $nums = $cd.find('.time-number'); // [day, hour, min, sec]

      function ensureFuture() {
        if (!loopMs) return;
        const now = Date.now();
        if (deadline <= now) {
          const steps = Math.ceil((now - deadline) / loopMs);
          deadline += Math.max(1, steps) * loopMs; 
          $cd.attr('data-deadline', deadline).data('deadline', deadline);
        }
      }

      function setValues(d, h, m, s) {
        const vals = [d, h, m, s].map(v => String(v).padStart(2, '0'));
        $nums.each(function (i) { $(this).text(vals[i] ?? '00'); });
      }

      function update() {
        const now = Date.now();
        let remaining = deadline - now;

        if (remaining <= 0) {
          if (loopMs) {
            ensureFuture();
            remaining = deadline - Date.now(); 
          } else {
            setValues(0, 0, 0, 0);
            const t = $cd.data('t888Timer'); if (t) clearInterval(t);
            return;
          }
        }

        const d = Math.floor(remaining / DAY);
        const h = Math.floor((remaining % DAY) / HOUR);
        const m = Math.floor((remaining % HOUR) / MIN);
        const s = Math.floor((remaining % MIN) / SEC);
        setValues(d, h, m, s);
      }

      ensureFuture();
      update();
      const timer = setInterval(update, 1000);
      $cd.data('t888Timer', timer);
    });
  }

  function initHotDealsSwiper($scope) {
    const $swiperEl = $scope.find('.swiper-pet-hot-deals');
    if (!$swiperEl.length) return;
    
    $swiperEl.each(function() {
      const $this = $(this);
      
      const columns = parseInt($this.attr('data-columns'), 10) || 5;
      const autoplayEnabled = $this.attr('data-autoplay') === 'yes';
      const autoplayDelaySeconds = parseInt($this.attr('data-autoplay-delay'), 10) || 3;
      const $container = $this.closest('.t888-pet-hot-deals-module');
      const $nextEl = $container.find('.nav-next')[0];
      const $prevEl = $container.find('.nav-prev')[0];
      
      const swiperOptions = {
          slidesPerView: 1,
          spaceBetween: 20,
          loop: true,
          navigation: {
              nextEl: $nextEl,
              prevEl: $prevEl
          },
          breakpoints: {
              576: { slidesPerView: 2 },
              768: { slidesPerView: 3 },
              992: { slidesPerView: 4 },
              1200: { slidesPerView: columns }
          }
      };

      if (autoplayEnabled) {
          swiperOptions.autoplay = {
              delay: autoplayDelaySeconds * 1000,
              disableOnInteraction: false,
          };
      } else {
          swiperOptions.autoplay = false;
      }

      const initSwiper = function() {
          if ($this[0].swiper) {
              $this[0].swiper.destroy(true, true);
          }
          if (typeof Swiper !== 'undefined') {
              const swiperInstance = new Swiper($this[0], swiperOptions);
              $this[0].swiper = swiperInstance;
              if (!autoplayEnabled && swiperInstance.autoplay) {
                  swiperInstance.autoplay.stop();
              }
          } else if (typeof elementorFrontend !== 'undefined' && elementorFrontend.utils && elementorFrontend.utils.swiper) {
              new elementorFrontend.utils.swiper($this, swiperOptions).then(function(newSwiperInstance) {
                  $this[0].swiper = newSwiperInstance;
                  if (!autoplayEnabled && newSwiperInstance.autoplay) {
                      newSwiperInstance.autoplay.stop();
                  }
              });
          }
      };

      initSwiper();
    });
  }

  // Frontend
  $(function () { 
      initCountdown($(document)); 
  });

  $(window).on('load', function() {
      setTimeout(function() {
          initHotDealsSwiper($(document));
      }, 500);
  });

  // Elementor Editor
  $(window).on('elementor/frontend/init', function () {
    if (typeof elementorFrontend === 'undefined' || !elementorFrontend.hooks) return;
    // elementorFrontend.hooks.addAction('frontend/element_ready/global', initCountdown);
    elementorFrontend.hooks.addAction('frontend/element_ready/t888-hot-deals.default', initCountdown);
    elementorFrontend.hooks.addAction('frontend/element_ready/t888-pet-hot-deals-carousel.default', function($scope) {
        initCountdown($scope);
        initHotDealsSwiper($scope);
    });
  });
})(jQuery);
