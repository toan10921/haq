(function($){
  var initCompare = function($scope, $){
    $scope.find('.twentytwenty-container').each(function () {
        var $el = $(this);
        if ($el.data('t888-init')) return; 
        $el.twentytwenty({
            default_offset_pct: 0.5,
            orientation: 'horizontal',
            no_overlay: true
        });
        $el.data('t888-init', true);
    });
  };

  $(window).on('elementor/frontend/init', function(){
    elementorFrontend.hooks.addAction('frontend/element_ready/t888-image-compare.default', initCompare);
  });
})(jQuery);
