(function ($) {
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
          spaceBetween: 10,
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
  $(window).on('load', function() {
      setTimeout(function() {
          initHotDealsSwiper($(document));
      }, 500);
  });

  // Elementor Editor
  $(window).on('elementor/frontend/init', function () {
    if (typeof elementorFrontend === 'undefined' || !elementorFrontend.hooks) return;
    elementorFrontend.hooks.addAction('frontend/element_ready/t888-pet-hot-deals-carousel.default', function($scope) {
        initHotDealsSwiper($scope);
    });
  });
})(jQuery);
