(function($) {
	"use strict";

	 $('.nivoSlider').nivoSlider({
                effect: 'random',
                slices: 15,
                boxCols: 12,
                boxRows: 6,
                animSpeed: 500,
                pauseTime: 8000,
                directionNav: true,
                controlNav: true,
                pauseOnHover: true,
                prevText: '<i class="fa fa-angle-left"></i>',
                nextText: '<i class="fa fa-angle-right"></i>',
                afterLoad: function(){
                    $('#slider').find('.nivo-caption').addClass('slider-caption-bg');
                }
            });
	
})(jQuery);