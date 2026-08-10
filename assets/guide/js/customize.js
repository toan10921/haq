(function($){
    "use strict";
	$(document).ready(function() {		
		$('#documenter_nav li:first-child a').addClass('actived');
		$( "#documenter_nav li a,#documenter_logo" ).click(function(event){
			event.preventDefault();
			event.stopPropagation();
			$( "#documenter_nav li a" ).not($(this)).not($(this).parents('li.has-child').find('>a')).removeClass( "actived" );
			$(this).toggleClass('actived');
			$('html,body').animate({scrollTop:$(this.hash).offset().top}, 1000);
			$('body').addClass('onscroll');
			setTimeout(function(){ 
				$('body').removeClass('onscroll');
			}, 2000);
			$( "#documenter_nav ul" ).not($(this).next()).not($(this).parents('li.has-child').find('>ul')).slideUp(1000);
			$(this).next().slideToggle(1000);
			if($('#documenter_nav').height() > 350) $('#documenter_nav_wrap').mCustomScrollbar();

		});
		// $( "#documenter_nav li > a" ).click(function(event){
		// 	event.preventDefault();
		// 	event.stopPropagation();
		// 	$( "#documenter_nav ul" ).not($(this).next()).not($(this).parents('li.has-child').find('>ul')).slideUp(1000);
		// 	$(this).next().slideToggle(1000);
		// 	if($('#documenter_nav').height() > 350) $('#documenter_nav_wrap').mCustomScrollbar();
		// });
		$("a.popup-gallerys").fancybox();
	});

	$(window).load(function() {	
		$('#documenter_nav_wrap').mCustomScrollbar();
		$(window).scroll(function() {
			if(!$('body').hasClass('onscroll')){
				var top = $(window).scrollTop();
				$('.scroll-active').each(function(){
					var s_top = $(this).offset().top - 20;
					var e_top = s_top + $(this).height() + 30;
					var seff = $('a[href="#'+$(this).attr('id')+'"]');
					if(top >= s_top && top <= e_top){
						if(!seff.hasClass('actived')){
							console.log($(this).attr('id'));
							$( "#documenter_nav ul" ).not(seff.next()).not(seff.parents('li.has-child').find('>ul')).slideUp(1000);
							seff.next().slideDown(1000);
							seff.addClass('actived');
						}
					}
					else{
						seff.removeClass('actived');
						//seff.parents('li.has-child').find('>a').removeClass('actived');
					}
				})
			}
		});
	});


})(jQuery);
