jQuery(document).ready(function ($) {
    const $button = $('.add-set-to-cart-btn');

    if (!$button.length) return;

    $button.on('click', function () {
        const productIds = JSON.parse($button.attr('data-products'));
        $button.addClass('loading');
        $.ajax({
            type: 'POST',
            url: t888_ajax.ajax_url,
            data: {
                action: 't888_add_set_to_cart',
                product_ids: JSON.stringify(productIds)
            },
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    $button.removeClass('loading').addClass('added');
                    let fragments = response.data.fragments;
                    if (!$('.mini-cart-box').length) return;
                    if (fragments) {
                        let html = response.data.fragments['div.widget_shopping_cart_content'];
                        $('.mini-cart-main-content').html(html); // Update the mini cart content
                    }
                    $('.mini-cart-link, .mini-cart-content, .mini-cart-overlay').toggleClass('active-cart');

                }
            }
        });


    });
});
