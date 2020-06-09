(function($) {
	"use strict";

	$('#camera_wrap_1').camera({
                thumbnails: true,
                height: '40%',
                loader: 'pie',
                loaderPadding: 1,
                loaderStroke: 5,
                onLoaded: function() {
                    $('#camera_wrap_1').find('.camera_next').html('<i class="fa fa-angle-right"></i>');
                    $('#camera_wrap_1').find('.camera_prev').html('<i class="fa fa-angle-left"></i>');
                }
            });
	
})(jQuery);