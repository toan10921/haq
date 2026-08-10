jQuery(document).ready(function ($) {
  const $panel = $('#t888-search-panel'); // footer panel
  const $form = $panel.find('form.search-form');

  console.group('[SEARCH] jQuery init');
  console.log('[SEARCH] panel exists:', $panel.length);
  console.log('[SEARCH] form exists:', $form.length);
  console.groupEnd();

  $(document).on('click', '.custom-dropdown-menu-categories li a', function (e) {
    e.preventDefault();
    const $a = $(this);
    const category = $a.data('category');
    const $wrapForm = $a.closest('form.search-form');

    console.log('[SEARCH] click category:', category, 'form found:', $wrapForm.length);

    $wrapForm.find('.custom-dropdown-toggle-search').text($a.text());
    $wrapForm.find('select[name="category"]').val(category);

    if ($wrapForm.hasClass('search-ajax')) {
      console.log('[SEARCH] trigger keyup.search due to category change');
      $wrapForm.find('input[name="s"]').trigger('keyup.search');
    }
  });

  $(document).on('click', '.search-ajax input[name="s"]', function (e) {
    e.preventDefault();
    e.stopPropagation();
    console.log('[SEARCH] input clicked, add .active to form');
    $(this).closest('.search-ajax').addClass('active');
  });

  $(document).on('keyup.search', '.search-ajax input[name="s"]', function () {
    const $inp = $(this);
    const $wrap = $inp.closest('.search-ajax');
    const query = $inp.val();
    const msgShort = $wrap.find('.list-search-results').data('search_min_length');

    console.log('[SEARCH] keyup.search value:', query);

    if (query.length < 3) {
      console.log('[SEARCH] under 3 chars → show short msg');
      $wrap.find('.list-search-results').html('<p class="text-center m-0">' + msgShort + '</p>');
      return;
    }

    const category = $wrap.find('select[name="category"]').val();
    const postType = $wrap.find('input[name="post_type"]').val();
    console.log('[SEARCH] perform AJAX with:', { query, category, postType });

    if (typeof window.searchDebounceTimeout !== 'undefined') {
      clearTimeout(window.searchDebounceTimeout);
    }
    window.searchDebounceTimeout = setTimeout(function () {
      $wrap.find('.list-search-results').html('<p class="text-center m-0"><i class="las la-circle-notch spinner"></i></p>');
      $.ajax({
        url: t888_ajax.ajax_url,
        type: 'POST',
        data: {
          action: 'ajax_search_form',
          s: query,
          category: category,
          post_type: postType
        },
        success: function (response) {
          console.log('[SEARCH] AJAX success:', response);
          if (response && response.success) {
            $wrap.find('.list-search-results').html(response.data);
          } else {
            $wrap.find('.list-search-results').html('<p class="text-center m-0">No results</p>');
          }
        },
        error: function (xhr) {
          console.warn('[SEARCH] AJAX error:', xhr.status, xhr.responseText);
          $wrap.find('.list-search-results').html('<p class="text-center m-0">Request error</p>');
        }
      });
    }, 500);
  });

  $(document).on('click', '#t888-search-panel .t888-search-overlay', function (e) {
    e.preventDefault();
    e.stopPropagation();
    console.log('[SEARCH] overlay background clicked → close');
    $panel.removeClass('open');
    $form.removeClass('active');
  });

  // Close inline AJAX results when clicking outside
  $(document).on('click', function (e) {
    if ($(e.target).closest('.search-ajax').length === 0) {
      $('.t888-search-form-inline-wrap .search-ajax, .t888-search-form-style3 .search-ajax').removeClass('active');
    }
  });
});

(function () {
  function initOverlay() {
    var triggers = document.querySelectorAll('.js-overlay-trigger');
    var overlay = document.querySelector('#t888-search-panel .t888-search-content.overlay')
      || document.querySelector('#t888-search-panel .overlay-genie');
    var overlayBg = document.querySelector('#t888-search-panel .t888-search-overlay');
    var closeBtn = document.querySelector('#t888-search-panel .js-overlay-close, #t888-search-panel .overlay-close');

    console.group('[SEARCH] Vanilla init (safe)');
    console.log('triggers:', triggers.length);
    console.log('overlay exists:', !!overlay);
    console.log('overlayBg exists:', !!overlayBg);
    console.log('closeBtn exists:', !!closeBtn);
    console.groupEnd();

    if (!overlay) {
      console.warn('[SEARCH] overlay not found at init → abort init');
      return false;
    }

    var hasSnap = !!(window.Snap && window.mina);
    var path = null, steps = [], stepsTotal = 0, animating = false;

    if (hasSnap) {
      var svg = overlay.querySelector('svg');
      if (svg) {
        var s = Snap(svg);
        path = s.select('path');
        steps = (overlay.getAttribute('data-steps') || '').split(';').filter(Boolean);
        stepsTotal = steps.length;
        console.log('[SEARCH] Snap OK. stepsTotal:', stepsTotal, 'path exists:', !!path);
      } else {
        hasSnap = false;
        console.warn('[SEARCH] Snap loaded but SVG/path missing → no animation');
      }
    } else {
      console.warn('[SEARCH] Snap/mina not loaded → no animation');
    }

    function openOverlay(triggerEl) {
      console.log('[SEARCH] openOverlay');
      if (overlay.classList.contains('open') || animating) return;
      var panel = document.getElementById('t888-search-panel');
      if (!panel) return;

      
      if (triggerEl) triggerEl.setAttribute('aria-expanded', 'true');
      panel.classList.add('open');
      overlay.classList.add('open');

      if (!hasSnap || !path || !stepsTotal) return;
      animating = true;
      var i = 0;
      (function next() {
        i++;
        if (i > stepsTotal - 1) { animating = false; console.log('[SEARCH] open animation done'); return; }
        path.animate({ path: steps[i] }, 60, mina.linear, next);
      })();
    }

    function closeOverlay() {
      console.log('[SEARCH] closeOverlay');
      if (!overlay.classList.contains('open') || animating) return;
      var panel = document.getElementById('t888-search-panel');
      if (panel) panel.classList.remove('open');
      overlay.classList.remove('open');
      document.querySelectorAll('.js-overlay-trigger').forEach(function (t) {
        t.setAttribute('aria-expanded', 'false');
      });

      if (!hasSnap || !path || !stepsTotal) return;
      animating = true;
      var i = stepsTotal - 1;
      (function prev() {
        i--;
        if (i < 0) { animating = false; overlay.classList.remove('close'); console.log('[SEARCH] close animation done'); return; }
        path.animate({ path: steps[i] }, 60, mina.linear, prev);
      })();
    }

    if (triggers.length === 0) {
      console.warn('[SEARCH] No .js-overlay-trigger found (check header icon class). Will still bind delegated handler.');
    }
    triggers.forEach(function (trigger) {
      trigger.addEventListener('click', function (e) { e.preventDefault(); openOverlay(trigger); });
    });

    document.addEventListener('click', function (e) {
      var t = e.target.closest('.js-overlay-trigger');
      if (t) { e.preventDefault(); console.log('[SEARCH] delegated trigger click'); openOverlay(t); }
    });

    if (closeBtn) {
      closeBtn.addEventListener('click', function (e) { e.preventDefault(); closeOverlay(); });
    }
    if (overlayBg) {
      overlayBg.addEventListener('click', function (e) { e.preventDefault(); closeOverlay(); });
    }
    document.addEventListener('keydown', function (e) { if (e.key === 'Escape') closeOverlay(); });

    window.addEventListener('load', function () {
      var panel = document.getElementById('t888-search-panel');
      if (panel && panel.classList.contains('open')) {
        console.warn('[SEARCH] panel had .open on load → removing');
        panel.classList.remove('open');
        overlay.classList.remove('open');
      }
    });

    return true;
  }

  function bootWhenReady() {
    if (initOverlay()) return;

    var mo = new MutationObserver(function () {
      if (document.querySelector('#t888-search-panel .overlay-genie') ||
        document.querySelector('#t888-search-panel .t888-search-content.overlay')) {
        console.log('[SEARCH] MutationObserver: overlay arrived → init now');
        mo.disconnect();
        initOverlay();
      }
    });
    mo.observe(document.body, { childList: true, subtree: true });
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', bootWhenReady);
  } else {
    bootWhenReady();
  }
})();


