jQuery(document).ready(function ($) {

  var $inquiryModal = $();
  var inquiryLastTrigger = null;
  var inquiryHideTimer = null;

  function closeInquiryModal() {
    if (!$inquiryModal.length || !$inquiryModal.hasClass('is-open')) return;

    var $modalToHide = $inquiryModal;
    $modalToHide.removeClass('is-open').attr('aria-hidden', 'true');
    $('body').removeClass('t888-inquiry-open');
    window.clearTimeout(inquiryHideTimer);
    inquiryHideTimer = window.setTimeout(function () {
      $modalToHide.attr('hidden', 'hidden');
    }, 220);

    if (inquiryLastTrigger) {
      inquiryLastTrigger.focus();
    }
  }

  function setContactFormProduct($modal, productName, productUrl) {
    var $form = $modal.find('.wpcf7-form').first();
    if (!$form.length) return;

    var setValue = function (names, fallbackName, value) {
      var $fields = $();
      names.forEach(function (name) {
        $fields = $fields.add($form.find('[name="' + name + '"]'));
      });

      if (!$fields.length) {
        $fields = $('<input>', { type: 'hidden', name: fallbackName }).appendTo($form);
      }

      $fields.val(value).trigger('change');
    };

    setValue(['product-name', 'product_name', 'san-pham'], 'product-name', productName);
    setValue(['product-url', 'product_url', 'duong-dan-san-pham'], 'product-url', productUrl);
  }

  function openInquiryModal(trigger, productName, productUrl) {
    var $wrapper = $(trigger).closest('[data-inquiry-modal-id]');
    var modalId = $wrapper.attr('data-inquiry-modal-id');
    var modal = modalId ? document.getElementById(modalId) : null;

    // Product cards outside Style 6 (related/upsell/latest on a single
    // product page) use the shared modal rendered in the footer.
    if (!modal) {
      modal = document.getElementById('t888-global-inquiry-modal');
    }

    if (!modal) {
      // Keep a useful fallback for pages where the modal was not rendered.
      if (productUrl) window.location.href = productUrl;
      return;
    }

    if ($inquiryModal.length && $inquiryModal[0] !== modal) {
      closeInquiryModal();
    }

    inquiryLastTrigger = trigger;
    window.clearTimeout(inquiryHideTimer);
    $inquiryModal = $(modal);

    // Elementor containers and widget wrappers can apply inherited form and
    // typography styles. Keep every inquiry popup in the same DOM context so
    // Product Tabs, List Product and single-product cards look identical.
    if (!$inquiryModal.parent().is('body')) {
      $inquiryModal.appendTo(document.body);
    }

    $inquiryModal.data({ productName: productName, productUrl: productUrl });
    $inquiryModal.removeAttr('hidden').attr('aria-hidden', 'false');
    $inquiryModal.find('.t888-product-inquiry-modal__product strong').text(productName);
    $inquiryModal.find('.wpcf7-response-output').empty();
    setContactFormProduct($inquiryModal, productName, productUrl);
    $('body').addClass('t888-inquiry-open');

    // Force the initial state to render before the opening transition.
    void modal.offsetWidth;
    $inquiryModal.addClass('is-open');
    window.setTimeout(function () {
      var $firstField = $inquiryModal.find('.wpcf7-form input:not([type="hidden"]), .wpcf7-form textarea, .wpcf7-form select').filter(':visible').first();
      ($firstField.length ? $firstField : $inquiryModal.find('.t888-product-inquiry-modal__close')).trigger('focus');
    }, 80);
  }

  $(document).on('click', '.t888-product-inquiry-modal', function (event) {
    if (event.target === this || $(event.target).closest('.t888-product-inquiry-modal__close').length) {
      $inquiryModal = $(this);
      closeInquiryModal();
    }
  });

  $(document).on('keydown', '.t888-product-inquiry-modal', function (event) {
    $inquiryModal = $(this);

    if (event.key === 'Escape') {
      event.preventDefault();
      closeInquiryModal();
      return;
    }

    if (event.key !== 'Tab') return;

    var $focusable = $inquiryModal.find('button:not(:disabled), input:not([type="hidden"]), textarea, select, a[href]').filter(':visible');
    if (!$focusable.length) return;

    var first = $focusable[0];
    var last = $focusable[$focusable.length - 1];
    if (event.shiftKey && document.activeElement === first) {
      event.preventDefault();
      last.focus();
    } else if (!event.shiftKey && document.activeElement === last) {
      event.preventDefault();
      first.focus();
    }
  });

  document.addEventListener('wpcf7mailsent', function (event) {
    var $modal = $(event.target).closest('.t888-product-inquiry-modal');
    if (!$modal.length) return;

    window.setTimeout(function () {
      setContactFormProduct($modal, $modal.data('productName') || '', $modal.data('productUrl') || '');
    }, 0);
  });

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
      var $actionLink = $('<button>', {
        'class': 't888-style6-product-link t888-shop-card__contact',
        'type': 'button',
        'data-product-name': productName,
        'data-product-url': productUrl,
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

  $(document).on('click', '.t888-product-tabs-wrapper.style6 .t888-style6-product-link, .t888-inquiry-trigger', function (event) {
    event.preventDefault();

    var $button = $(this);
    var $card = $button.closest('.grid-product-item, .t888-shop-card');
    var productName = $button.attr('data-product-name') || $.trim($card.find('.product-title, .hcard-title, .t888-shop-card__title').first().text());
    var productUrl = $button.attr('data-product-url') || $card.find('.product-link, .hcard-img-link, .product-title a, .hcard-title a, .t888-shop-card__title a').first().attr('href') || window.location.href;

    openInquiryModal(this, productName || 'Sản phẩm cần tư vấn', productUrl);
  });

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



