jQuery(document).ready(function ($) {

  /**
   * Give Style 6 product cards the same visual action strip used by the
  * Shop Product Grid without changing the widget query or PHP templates.
  */
  function enhanceStyle6Cards($root) {
    var wrapperSelector = '.t888-product-tabs-wrapper.style6';
    var $wrappers = $root.filter(wrapperSelector)
      .add($root.find(wrapperSelector))
      .add($root.closest(wrapperSelector));

    $wrappers.addClass('listsp');

    $wrappers.find('.grid-product-item').each(function () {
      var $card = $(this);

      if ($card.hasClass('t888-shop-card-look')) return;

      var $media = $card.find('.product-thumbnail, .hcard-image-col').first();
      var $productLink = $card.find('.product-link, .hcard-img-link, .product-title a, .hcard-title a').first();
      var $meta = $card.find('.product-content, .hcard-info-col').first();
      var $title = $card.find('.product-title, .hcard-title').first();
      var $price = $card.find('.product-price, .hcard-price').first();
      var productUrl = $productLink.attr('href');

      // Reuse the exact presentation hooks used by List Product's compact card.
      $card.addClass('t888-shop-card-look t888-shop-card');
      $media.addClass('t888-shop-card__media');
      $productLink.addClass('t888-shop-card__image');
      $meta.addClass('t888-shop-card__meta');
      $title.addClass('t888-shop-card__title');
      $price.addClass('t888-shop-card__price');
      $card.find('.product-badge.sale').addClass('t888-shop-card__sale');

      // List Product renders WooCommerce's square 300x300 thumbnail. Style 6
      // receives the full image, so prefer the same generated thumbnail when
      // it exists and safely retain the original image when it does not.
      $media.find('img.primary-img, .hcard-img-link img').first().each(function () {
        var $image = $(this);
        var originalUrl = $image.attr('src');

        if (!originalUrl || $image.data('listsp-thumbnail-checked')) return;
        $image.data('listsp-thumbnail-checked', true);

        var urlParts = originalUrl.split('?');
        var path = urlParts[0];
        var query = urlParts.length > 1 ? '?' + urlParts.slice(1).join('?') : '';
        var squareUrl = path.replace(/(?:-\d+x\d+)?(\.[a-z0-9]+)$/i, '-300x300$1') + query;

        if (squareUrl === originalUrl) return;

        var squareImage = new Image();
        squareImage.onload = function () {
          $image.removeAttr('srcset sizes').attr('src', squareUrl);
        };
        squareImage.src = squareUrl;
      });

      if ($price.length && !$price.find('.woocommerce-Price-amount').length) {
        $price
          .empty()
          .addClass('t888-style6-empty-price')
          .attr('hidden', 'hidden');
        $price[0].style.setProperty('display', 'none', 'important');
      }

      if (!$media.length || !productUrl || $media.find('.t888-style6-product-link').length) return;

      var productName = $.trim($card.find('.product-title, .hcard-title').first().text());
      var ariaLabel = productName ? 'Liên hệ về ' + productName : 'Liên hệ';
      var $actionLink = $('<a>', {
        'class': 't888-style6-product-link t888-shop-card__contact',
        'href': productUrl,
        'aria-label': ariaLabel
      });

      $actionLink.append($('<span>', {
        'class': 't888-style6-product-link__text t888-shop-card__contact-text',
        'text': 'Liên hệ'
      }));
      $actionLink.append(
        '<span class="t888-style6-product-link__icon t888-shop-card__contact-icon" aria-hidden="true">' +
          '<svg viewBox="0 0 24 24"><path d="M7 17 17 7M10 7h7v7"/></svg>' +
        '</span>'
      );
      $media.append($actionLink);
    });
  }

  /**
   * Sync the visible time-panel inside a tab panel
   * to match the currently active time-filter button.
   */
  function syncTimePanelForWrapper($wrapper, $panel) {
    var $timeFilter = $wrapper.find('.t888-style6-time-filter');
    if (!$timeFilter.length) return; // time filter not enabled

    var activePeriod = $timeFilter.find('.t888-time-filter-btn.active').data('period') || 'week';
    $panel.find('.t888-time-panel').hide();
    $panel.find('.t888-time-panel[data-period="' + activePeriod + '"]').show();
  }

  $(document).on('click', '.t888-product-tabs-wrapper .t888-product-tabs-nav li', function () {
    var $tab = $(this);
    var tabId = $tab.data('tab');
    var $wrapper = $tab.closest('.t888-product-tabs-wrapper');

    if (!tabId || !$wrapper.length) {
      return;
    }

    // Active tab (scoped)
    $wrapper.find('.t888-product-tabs-nav li').removeClass('active');
    $tab.addClass('active');

    // Show/Hide tab panels (scoped)
    $wrapper.find('.t888-tab-panel').hide();
    var $targetPanel = $wrapper.find('.' + tabId);
    $targetPanel.show();

    if ($wrapper.hasClass('style6')) {
      enhanceStyle6Cards($targetPanel);
      $targetPanel.removeClass('is-entering');
      // Force a reflow so repeated visits to a tab replay the entrance effect.
      void $targetPanel[0].offsetWidth;
      $targetPanel.addClass('is-entering');
      window.setTimeout(function () {
        $targetPanel.removeClass('is-entering');
      }, 320);
    }

    // Sync time filter period to newly visible panel
    syncTimePanelForWrapper($wrapper, $targetPanel);

    // Swiper sync inside target panel
    var swiperContainer = $targetPanel.find('.swiper-container')[0];
    if (swiperContainer && swiperContainer.swiper) {
      swiperContainer.swiper.update();
      swiperContainer.swiper.slideTo(0);
    }
  });

  $(document).on('click', '.t888-product-tabs-wrapper.style6 .t888-style6-tab-arrow', function () {
    var $btn = $(this);
    var $wrapper = $btn.closest('.t888-product-tabs-wrapper.style6');
    var $tabs = $wrapper.find('.t888-product-tabs-nav li');
    var $active = $tabs.filter('.active');

    if (!$tabs.length) {
      return;
    }

    var currentIndex = Math.max(0, $tabs.index($active));
    var nextIndex = $btn.hasClass('style6-prev') ? currentIndex - 1 : currentIndex + 1;

    if (nextIndex < 0) {
      nextIndex = $tabs.length - 1;
    }
    if (nextIndex >= $tabs.length) {
      nextIndex = 0;
    }

    $tabs.eq(nextIndex).trigger('click');
  });

  $(document).on('click', '.t888-style6-time-filter .t888-time-filter-btn', function () {
    var $btn = $(this);
    var period = $btn.data('period');
    var $wrapper = $btn.closest('.t888-product-tabs-wrapper.style6');

    $btn.siblings('.t888-time-filter-btn').removeClass('active');
    $btn.addClass('active');

    $wrapper.find('.t888-tab-panel').each(function () {
      var $panel = $(this);
      $panel.find('.t888-time-panel').hide();
      $panel.find('.t888-time-panel[data-period="' + period + '"]').show();
    });
  });

  enhanceStyle6Cards($(document));

  $(window).on('elementor/frontend/init', function () {
    elementorFrontend.hooks.addAction('frontend/element_ready/t888-product-tabs.default', function ($scope) {
      enhanceStyle6Cards($scope);
    });
  });
});

jQuery(document).on('click', '.t888-loadmore-button', function (e) {
  e.preventDefault();

  const $btn = jQuery(this);
  if ($btn.hasClass('loading')) return;

  const $panel = $btn.closest('.t888-tab-panel');
  const $grid = $panel.find('.products.grid');
  const tabIdx = $btn.closest('.t888-loadmore-wrap').data('tab');

  // paged/total
  let paged = parseInt($btn.attr('data-paged') || '1', 10) + 1;
  let total = parseInt($btn.attr('data-total') || '1', 10);
  if (isNaN(paged) || isNaN(total)) return;

  // params
  let filterMode = $btn.data('filter-mode') || 'categories';
  let productFilter = $btn.data('product-filter') || 'new';
  let productIds = $btn.data('product-ids');
  let categories = $btn.data('categories');
  let productLimit = parseInt($btn.data('product-limit'), 10) || 8;

  try { if (typeof productIds === 'string') productIds = JSON.parse(productIds); } catch (e) { productIds = []; }
  try { if (typeof categories === 'string') categories = JSON.parse(categories); } catch (e) { categories = []; }
  if (!Array.isArray(productIds)) productIds = [];
  if (!Array.isArray(categories)) categories = [];


  $btn.addClass('loading');

  jQuery.ajax({
    url: (typeof my_ajax_object !== 'undefined') ? my_ajax_object.ajax_url : '/wp-admin/admin-ajax.php',
    type: 'POST',
    dataType: 'json',
    data: {
      action: 't888_load_more_products',
      tab_index: tabIdx,
      paged: paged,
      filter_mode: filterMode,
      product_filter: productFilter,
      product_ids: productIds,
      categories: categories,
      product_limit: productLimit,
    },
    success: function (res) {
      if (res && res.success) {
        if (res.data && res.data.html) $grid.append(res.data.html);


        if (res.data && res.data.total_pages) {
          total = parseInt(res.data.total_pages, 10) || total;
          $btn.attr('data-total', total);
        }
        if (res.data && res.data.paged) {
          paged = parseInt(res.data.paged, 10) || paged;
        }
        $btn.attr('data-paged', paged);


        if (paged >= total) {
          $btn.closest('.t888-loadmore-wrap').remove();
        }
      }

      $btn.removeClass('loading');
    },
    error: function () {
      $btn.removeClass('loading');
    }
  });
});



(function ($) {
  function two(n) { return n.toString().padStart(2, '0'); }

  function initCountdown($root) {
    $root.find('.countdown-productstabs-style4').each(function () {
      const $el = $(this);
      const old = $el.data('cdTimer');
      if (old) { clearInterval(old); $el.removeData('cdTimer'); }

      let deadline = Number($el.data('deadline'));
      if (!deadline || isNaN(deadline)) return;
      if (deadline < 1e12) deadline *= 1000;

      function tick() {
        const dist = deadline - Date.now();
        if (dist <= 0) {
          $el.find('.countdown-days,.countdown-hours,.countdown-mins,.countdown-secs').text('00');
          return;
        }
        const d = Math.floor(dist / 86400000);
        const h = Math.floor((dist % 86400000) / 3600000);
        const m = Math.floor((dist % 3600000) / 60000);
        const s = Math.floor((dist % 60000) / 1000);
        $el.find('.countdown-days').text(two(d));
        $el.find('.countdown-hours').text(two(h));
        $el.find('.countdown-mins').text(two(m));
        $el.find('.countdown-secs').text(two(s));
      }
      tick();
      $el.data('cdTimer', setInterval(tick, 1000));
    });
  }

  $(function () { initCountdown($(document)); });

  $(window).on('elementor/frontend/init', function () {
    // elementorFrontend.hooks.addAction('frontend/element_ready/global', initCountdown);
    elementorFrontend.hooks.addAction('frontend/element_ready/t888-product-tabs.default', initCountdown);
  });

  $(document).on('click', '.t888-product-tabs-nav [data-tab]', function () {
    const tab = $(this).data('tab');
    const $panel = $('.t888-tab-panel.' + tab);
    setTimeout(function () { initCountdown($panel); }, 10);
  });
  $(document).on('init slideChange', '.eltech888-swiper-slider', function () {
    initCountdown($(this));
  });
})(jQuery);



