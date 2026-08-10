<div id="popup-shipping" class="shipping-popup modal" style="display:none;">
    <div class="modal-content">
        <button class="close-popup" aria-label="Close"><i class="las la-times"></i></button>
        <div class="popup-title-wrapper">
        <h3 class="popup-title">
            <?php echo esc_html(get_theme_mod('shipping_popup_title', __('ATACHEE FREE SHIPPING:', 'nebon'))); ?>
        </h3>
    </div>
        <div class="popup-item">
            <i class="las la-shipping-fast"></i>
            <div class="text">
                <h4 class="mt-0"><?php echo esc_html(get_theme_mod('shipping_popup_item1_title', __('DELIVERY', 'nebon'))); ?></h4>
                <p><?php echo nl2br(esc_html(get_theme_mod('shipping_popup_item1_content'))); ?></p>
            </div>
        </div>

        <div class="popup-item item-time">
            <i class="las la-stopwatch"></i>
            <div class="text">
                <h4 class="mt-0"><?php echo esc_html(get_theme_mod('shipping_popup_item2_title', __('DELIVERY TIMES', 'nebon'))); ?></h4>
                <p><?php echo nl2br(esc_html(get_theme_mod('shipping_popup_item2_content'))); ?></p>
            </div>
        </div>
    </div>
</div>
