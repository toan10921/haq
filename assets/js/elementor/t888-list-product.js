jQuery(document).ready(function ($) {
    // quick fix do not show sidebar when click button in mobile
    if($('.elementor-widget-t888-list-product').length > 0){
        $('body').addClass('context-product');
    }
});
