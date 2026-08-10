
(function ($) {

    // customizer blog sidebar

    wp.customize.section('blog_layout', function (section) {
        section.expanded.bind(function (isExpanded) {
            if (isExpanded) {
                wp.customize.previewer.previewUrl.set( global_var.default_category);
            }
        });
    });

    // customizer share social
    
    wp.customize.section('share_social', function (section) {
        section.expanded.bind(function (isExpanded) {
            if (isExpanded) {
                wp.customize.previewer.previewUrl.set( global_var.default_category);
            }
        });
    });

    



})(jQuery);