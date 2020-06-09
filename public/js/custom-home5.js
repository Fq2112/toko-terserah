(function($) {
	"use strict";

    //Preloader
    $(window).load(function() {
        $('.images-preloader').fadeOut();
    });

	//Header Scroll
	
	function init() {
        window.addEventListener('scroll', function(e){
			
			var mq = window.matchMedia( "(min-width: 992px)" );
			
			if (mq.matches) {
				var distanceY = window.pageYOffset || document.documentElement.scrollTop,
                shrinkOn = 10,
                header = document.querySelector(".main-bar");
            if (distanceY > shrinkOn) {
                classie.add(header,"smaller");
            } else {
                if (classie.has(header,"smaller")) {
                    classie.remove(header,"smaller");
                }

            }
			}

            
        });
    }
    window.onload = init();

    
    //Position Navigation

    $(window).on('resize', function () {
        var hbar = $('.site-header').outerHeight(),
            sbar = $('header .sub-bar').height();
        $('.main-bar .nav').css('top', hbar);
        $("header .main-bar").css('top', sbar);
    }).trigger('resize');
    
    (function($) {
        $(document).ready(function() {
            $(window).load(function() {
            $('.nav_slide_button').on('click',function() {
              $('.top-search').slideToggle();

            });
            $('#search-delete').on('click',function() {
              $(".top-search").slideUp("slow");
            });
          });
            
        document.querySelector("#search-toggle").addEventListener("click", function() {
            this.classList.toggle("active");
          });
        });
    }(window.jQuery || window.$));
    // Menu Mobile
	
	$('.btn-toggle').on('click',function(){

		var parent = $(this).parents('header');
		if(parent.find('nav').hasClass('menu-mobile')){
            parent.find('nav').removeClass('menu-mobile');
        }else{
            parent.find('nav').addClass('menu-mobile');
        }

        if(parent.find('.top-info').hasClass('menu-mobile')){
            parent.find('.top-info').removeClass('menu-mobile');
        }else{
            parent.find('.top-info').addClass('menu-mobile');
        }

	});
	
	//Submenu Dropdown Toggle
    if($('.site-header li.menu-item-has-children ul').length){
        $('.site-header li.menu-item-has-children').append('<div class="dropdown-btn"><Span class="fa fa-angle-down"></span></div>');

        //Dropdown Button
        $('.site-header li.menu-item-has-children .dropdown-btn').on('click', function() {
            $(this).prev('ul').slideToggle(500);
        });

        //Disable dropdown parent link
        $('.navigation li.menu-item-has-children > a').on('click', function(e) {
            e.preventDefault();
        });
    }

	//All Sliders


	var $portfolio = $( "#recent-slider" );
	$portfolio.owlCarousel({
        navigation: false, 
        navigationText: ["<i class='fa fa-caret-left'></i>","<i class='fa fa-caret-right'></i>"],
        slideSpeed : 600,
        autoPlay : 8000,
        items : 4,
		itemsDesktop      : [1199,3],
		itemsDesktopSmall     : [979,3],
		itemsTablet       : [768,2],
		itemsMobile       : [479,1],
        pagination: false
    });

    $('.next-slide').on('click',function(e){
    	e.preventDefault();
      	$portfolio.trigger( 'owl.next' );
    });
    $('.back-slide').on('click',function(e){
    	e.preventDefault();
      	$portfolio.trigger( 'owl.prev' );
    });

    $("#testimonials").owlCarousel({
        navigation: false, 
        slideSpeed : 600,
        autoPlay : 6000,
        singleItem:true,
        pagination: true,
        navigationText: [
	      "<i class='fa fa-caret-left'></i>",
	      "<i class='fa fa-caret-right'></i>"
	    ],
    });
    //Fun Fact

    jQuery(document).ready(function($){
        $('.counter-skills').counterUp({
            delay: 100,
            time: 2000
        });
    });
    //Isotop Projects

    window.onresize = function(event) {
        $('#gallery').isotope('reLayout');
    };

    $(window).load(function() {
        // --------------------------------------------------
        // filtering gallery
        // --------------------------------------------------
        var $container = $('#gallery');
        $container.isotope({
            itemSelector: '.item',
            filter: '*'
        });

        $('#filter a').on('click',function() {
            var $this = $(this);
            if ( $this.hasClass('current') ) {
                return false;
                }
            var $optionSet = $this.parents();
            $optionSet.find('.current').removeClass('current');
            $this.addClass('current');
                    
            var selector = $(this).attr('data-filter');
            $container.isotope({ 
                filter: selector,
            });
            return false;
        });

    });
    
	//Colorbox Project

	$(".zoomin").colorbox({rel:'item-image', maxWidth:'80%', maxHeight:'80%', transition: 'elastic'});

    jQuery(document).ready(function($){
            $("#layerslider").layerSlider({
                responsive: true,
                navPrevNext: true,
                navStartStop: true,
                navButtons: true,
                layersContainer: 1170,
                skinsPath: 'layerslider/skins/',
            });
    });
    
    jQuery(document).ready(function($){
             $(document).ready(function() {
             $('#my-video').backgroundVideo();
        });
    });
    jQuery(document).ready(function($){
            $('#model_page').modal('show');
    });
    
    jQuery(document).ready(function($){
         $(function() {
          $('a[href*="#"]:not([href="#"])').on('click',function() {
            if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
              var target = $(this.hash);
              target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
              if (target.length) {
                $('html, body').animate({
                  scrollTop: target.offset().top
                }, 1000);
                return false;
              }
            }
          });
        });
    });
    
	//Back To Top
	$('#to-top').on('click',function() {
        $("html, body").animate({ scrollTop: 0 }, 600);
        return false;
    });
	

})(jQuery);