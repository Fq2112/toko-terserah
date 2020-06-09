(function($) {
	"use strict";

	//-- Making the header sub-bar fixed --
    var jQueryheader2 = $('.site-header#site-header');
    var jQueryheaderTop2 = jQueryheader2.offset().top;

    $('.site-offset').height( jQueryheader2.outerHeight() )
     
    //-- Window Scroll Functions --
       
    $(window).scroll(function(){
      ($(window).scrollTop() > jQueryheaderTop2) ? $('.site-header').addClass('sitefixedHeader') : jQuery('.site-header').removeClass('sitefixedHeader');
    });
})(jQuery);