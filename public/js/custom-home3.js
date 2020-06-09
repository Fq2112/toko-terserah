(function($) {
    "use strict";

    //Preloader
    $(window).load(function() {
        $('.images-preloader').fadeOut();
    });

    //Header Scroll

    function init() {
        window.addEventListener('scroll', function(e) {

            var mq = window.matchMedia("(min-width: 992px)");

            if (mq.matches) {
                var distanceY = window.pageYOffset || document.documentElement.scrollTop,
                    shrinkOn = 10,
                    header = document.querySelector(".main-bar");
                if (distanceY > shrinkOn) {
                    classie.add(header, "smaller");
                } else {
                    if (classie.has(header, "smaller")) {
                        classie.remove(header, "smaller");
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

    jQuery(document).ready(function($) {
        $('.counter-skills').counterUp({
            delay: 100,
            time: 2000
        });
    });

    $("#testimonials").owlCarousel({
        navigation: false,
        slideSpeed: 600,
        autoPlay: 6000,
        singleItem: true,
        pagination: true,
        navigationText: [
            "<i class='fa fa-caret-left'></i>",
            "<i class='fa fa-caret-right'></i>"
        ],
    });


    //Colorbox Project

    $(".zoomin").colorbox({
        rel: 'item-image',
        maxWidth: '80%',
        maxHeight: '80%',
        transition: 'elastic'
    });

    //Back To Top
    $('#to-top').on('click',function() {
        $("html, body").animate({
            scrollTop: 0
        }, 600);
        return false;
    });

    // Owl Client
    $("#clients").owlCarousel({
        navigation: false,
        navigationText: ["<i class='fa fa-caret-left'></i>", "<i class='fa fa-caret-right'></i>"],
        slideSpeed: 600,
        autoPlay: 8000,
        items: 5,
        itemsDesktop: [1199, 5],
        itemsDesktopSmall: [979, 4],
        itemsTablet: [768, 3],
        itemsMobile: [479, 2],
        pagination: false
    });

    // Calling LayerSlider on the target element
    $("#layerslider").layerSlider({
        responsive: true,
        layersContainer: 1170,
        skinsPath: 'layerslider/skins/',
    });

})(jQuery);