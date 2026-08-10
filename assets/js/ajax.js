jQuery(document).ready(function ($) {
    function reloadMiniCartAfterAjaxCall(response) {
  try {
    const html = response?.data?.fragments?.['div.widget_shopping_cart_content'] || '';

    $('#t888-minicart-panel .mini-cart-main-content').html(html);

    let cart_count = $('#t888-minicart-panel .mini-cart-main-content').find('.cart-products-count').val();
    if (cart_count === undefined || cart_count === null) cart_count = 0;

    $('.mini-cart-box .mini-cart-link .cart-number').text(cart_count);
  } catch (e) {
    console.warn('[MiniCart] reload error:', e);
  }
}

function openMiniCartPanel() {
  $('#t888-minicart-panel').addClass('active-cart');
  $('body').addClass('minicart-open');
}
function closeMiniCartPanel() {
  $('#t888-minicart-panel').removeClass('active-cart');
  $('body').removeClass('minicart-open');
}

function handleMiniCartHeader() {
  const hasIcon = $('.mini-cart-box').length > 0;

  if ($('.mini-cart-box.aside-box').hasClass('active-cart-default')) {
    openMiniCartPanel();
  }

  $(document)
    .off('click.t888', '.mini-cart-link')
    .on('click.t888', '.mini-cart-link', function (e) {
      e.preventDefault();
      $('#t888-minicart-panel').toggleClass('active-cart');
      $('body').toggleClass('minicart-open');
    });

  $(document)
    .off('click.t888', '#t888-minicart-panel .mini-cart-overlay, #t888-minicart-panel .btn-close-mini-cart a, #t888-minicart-panel .btn-close-mini-cart')
    .on('click.t888', '#t888-minicart-panel .mini-cart-overlay, #t888-minicart-panel .btn-close-mini-cart a, #t888-minicart-panel .btn-close-mini-cart', function (e) {
      e.preventDefault();
      closeMiniCartPanel();
    });

  $(document)
    .off('keydown.t888Minicart')
    .on('keydown.t888Minicart', function (e) {
      if (e.key === 'Escape') closeMiniCartPanel();
    });

  $.ajax({
    url: t888_ajax.ajax_url,
    type: 'POST',
    data: { action: 't888_load_mini_cart' },
    success: function (response) {
      if (response && response.success) reloadMiniCartAfterAjaxCall(response);
    },
    error: function (err) { console.log(err); }
  });

  $(document)
    .off('click.t888', '.remove-cart-item')
    .on('click.t888', '.remove-cart-item', function (e) {
      e.preventDefault();
      const cart_item_key = $(this).data('cart_item_key');
      const $parent = $(this).closest('.mini_cart_item');
      $parent.addClass('removing');
      $parent.find('.product-cart-item-thumbnail')
             .prepend('<div class="mini-cart-loading"><i class="las la-circle-notch la-spin"></i></div>');

      $.ajax({
        url: t888_ajax.ajax_url,
        type: 'POST',
        data: { action: 't888_remove_cart_item', cart_item_key },
        success: function (response) {
          if (response && response.success) reloadMiniCartAfterAjaxCall(response);
        },
        error: function (err) { console.log(err); }
      });
    });

  $(document)
    .off('wc_fragments_refreshed.t888 wc_fragments_loaded.t888 added_to_cart.t888')
    .on('wc_fragments_refreshed.t888 wc_fragments_loaded.t888 added_to_cart.t888', function (e, fragments, cart_hash, $button) {
      if (e.type === 'added_to_cart') {
        openMiniCartPanel();
      }
      if (fragments && fragments['div.widget_shopping_cart_content']) {
        const mock = { data: { fragments: { 'div.widget_shopping_cart_content': fragments['div.widget_shopping_cart_content'] } } };
        reloadMiniCartAfterAjaxCall(mock);
      }
    });

}

function handleClickChangeQuantityMiniCart() {
  $(document)
    .off('click.t888', '.mini-cart-item-quantity .minus')
    .on('click.t888', '.mini-cart-item-quantity .minus', function (e) {
      e.preventDefault();
      const $input = $(this).siblings('.qty');
      const currentValue = parseInt($input.val() || 1, 10);
      if (currentValue > 1) $input.val(currentValue - 1).trigger('change');

      const $parent = $(this).closest('.mini_cart_item');
      const cart_item_key = $parent.data('cart_item_key');
      $parent.addClass('updating');
      $parent.find('.product-cart-item-thumbnail')
             .prepend('<div class="mini-cart-loading"><i class="las la-circle-notch la-spin"></i></div>');

      $.ajax({
        url: t888_ajax.ajax_url,
        type: 'POST',
        data: { action: 't888_update_cart_item_quantity', cart_item_key, quantity: $input.val() },
        success: function (response) {
          if (response && response.success) reloadMiniCartAfterAjaxCall(response);
        },
        error: function (err) {
          console.log(err);
          $parent.removeClass('updating').find('.mini-cart-loading').remove();
        }
      });
    });

  $(document)
    .off('click.t888', '.mini-cart-item-quantity .plus')
    .on('click.t888', '.mini-cart-item-quantity .plus', function (e) {
      e.preventDefault();
      const $input = $(this).siblings('.qty');
      const currentValue = parseInt($input.val() || 0, 10);
      $input.val(currentValue + 1).trigger('change');

      const $parent = $(this).closest('.mini_cart_item');
      const cart_item_key = $parent.data('cart_item_key');
      $parent.addClass('updating');
      $parent.find('.product-cart-item-thumbnail')
             .prepend('<div class="mini-cart-loading"><i class="las la-circle-notch la-spin"></i></div>');

      $.ajax({
        url: t888_ajax.ajax_url,
        type: 'POST',
        data: { action: 't888_update_cart_item_quantity', cart_item_key, quantity: $input.val() },
        success: function (response) {
          if (response && response.success) reloadMiniCartAfterAjaxCall(response);
        },
        error: function (err) {
          console.log(err);
          $parent.removeClass('updating').find('.mini-cart-loading').remove();
        }
      });
    });
}

    function setBtnAddToCartDisabled() {


        $(document).find('.list-product-item.ajax_add_to_cart.variable .add_to_cart_button').each(function () {
            const $button = $(this);
            $button.attr("disabled", true);
        });

    }

    function handleProductListVariations() {
        $(document).on('shop_ajax_content_loaded', function () {
            setBtnAddToCartDisabled();
            // this function declared in script.js
            handleVariationButtons();
        });

        $(document).on('click', '.list-product-item.ajax_add_to_cart.variable .add_to_cart_button', function (e) {
            e.preventDefault();
            let productData = $(this).parents('.list-product-item.ajax_add_to_cart').find('.variations_form').data("product_variations");
            if (!productData || !productData.length) {
                console.warn('No product variations found for this item.');
                return;
            }

            let lstVariationSelect = $(this).parents('.list-product-item.ajax_add_to_cart').find('.variations_form select[name^="attribute_pa"]');
        
            lstVariationSelect.map(function () {
                const $select = $(this);
                const attributeName = $select.data('attribute_name');
                const selectedValue = $select.val();
                if (selectedValue) {
                    productData = productData.filter(variation => variation.attributes[attributeName] === selectedValue
                    );
                }
         
                return productData;
            });
            const $button = $(this);
            const productId = $button.data('product_id');
            const variationId = productData[0]?.variation_id;
            const quantity = $button.data('quantity') || 1;

            $.ajax({
                url: t888_ajax.ajax_url,
                type: 'POST',
                data: {
                    action: 'add_to_cart_ajax',
                    product_id: variationId,
                    quantity: quantity
                },
                beforeSend: function () {
                    $button.addClass('loading');
                },
                success: function (response) {
                    $button.removeClass('loading');
                    if (response.success) {
                        openMiniCartPanel();
                        // Reload mini cart after adding to cart
                        reloadMiniCartAfterAjaxCall(response);
                    } else {
                        // Handle error case
                        console.error('Failed to add product to cart:', response.data);
                    }
                }
            });
        });
    }

    function handleLoadMoreProducts() {
        $(document).on('click', '.t888-list-loadmore-btn', function (e) {
            e.preventDefault();

            const $btn = $(this);
            const $wrap = $btn.closest('.t888-list-loadmore-wrap');
            const $list = $wrap.siblings('.products').first();

            const currentPage = Number($wrap.attr('data-current-page')) || 1;
            const maxPages = Number($wrap.attr('data-max-pages')) || 1;
            const nextPage = currentPage + 1;

            if ($btn.hasClass('loading')) return;
            if (nextPage > maxPages) { $btn.hide(); return; }

            $.ajax({
                url: (typeof t888_ajax_object !== 'undefined'
                    ? t888_ajax_object.ajax_url
                    : '/wp-admin/admin-ajax.php'),
                type: 'POST',
                data: {
                    action: 't888_list_product_loadmore',
                    paged: nextPage,
                    query_vars: $btn.attr('data-query-vars'),
                    style: $btn.data('style'),
                    slug: $btn.data('slug')
                },
                beforeSend: function () {
                    $btn.addClass('loading').prop('disabled', true);
                },
                success: function (res) {
                    const html = (res && res.data && res.data.html) ? res.data.html : '';
                    const serverMax = Number(res?.data?.max_pages) || maxPages;

                    if ($.trim(html).length) {
                        const $items = $(html);
                        $list.append($items);

                        $wrap.data('current-page', nextPage).attr('data-current-page', nextPage);

                        if (nextPage >= serverMax) {
                            $btn.hide();
                        } else {
                            $btn.removeClass('loading').prop('disabled', false);
                        }

                        $(document).trigger('shop_ajax_content_loaded', [res, $btn.data('slug')]);
                    } else {
                        $btn.hide();
                    }
                },
                error: function () {
                    $btn.removeClass('loading').prop('disabled', false);
                    console.error('Failed to load more products.');
                }
            });
        });
    }


    handleMiniCartHeader();
    handleClickChangeQuantityMiniCart();
    handleProductListVariations();
    setBtnAddToCartDisabled();
    handleLoadMoreProducts();

    $(document.body).on('added_to_cart', function (event, fragments, cart_hash, $button) {
        // handle logic when item is added to cart
       openMiniCartPanel();
        reloadMiniCartAfterAjaxCall({
            data: {
                fragments: fragments,
                cart_count: 0
            }
        });
    });

    $('body').on('click', '.quickview-button', function (e) {
        e.preventDefault();
        const $button = $(this);
        const productId = $button.data('product_id');
        if (!productId) return;
        $.ajax({
            url: t888_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 't888_quickview_product',
                product_id: productId
            },
            beforeSend: function () {
                $button.addClass('loading');
            },
            success: function (res) {
                Fancybox.show([
                    {
                        src: res,
                        type: 'html',
                    }
                ], {
                    animated: true,
                    dragToClose: false,
                    mainClass: "quick-view-wrap"
                });
                // remove loading class from button
                $button.removeClass('loading');

                // create new event for this action
                $(document).trigger('t888f_quickview_loaded', [res, productId]);
            }
        })
    });

    $(document).on('click', '.compare', function (e) {
        e.preventDefault();
        let product_id = $(this).data('product_id');
        $.ajax({
            url: t888_ajax.ajaxurl,
            data: {
                action: 'yith-woocompare-add-product',
                id: product_id
            },
            success: function (response) {
                // Optional: update compare widget
            }
        });
    });
});