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



    $("#about_me").owlCarousel({
        navigation: false, 
        slideSpeed : 600,
        autoPlay : 6000,
        singleItem:true,
        pagination: true,
        navigationText: [
          "<i class='fa fa-angle-left'></i>",
          "<i class='fa fa-angle-right'></i>"
        ],
    });
    $("#testimonials").owlCarousel({
        navigation: false, 
        slideSpeed : 600,
        autoPlay : 6000,
        singleItem:true,
        pagination: true,
        navigationText: [
          "<i class='fa fa-angle-left'></i>",
          "<i class='fa fa-angle-right'></i>"
        ],
    });
    //Project Slider
    $("#single-slider").owlCarousel({
        navigation: true, 
        slideSpeed : 600,
        autoPlay : 6000,
        singleItem:true,
        pagination: false,
        navigationText: [
          "<i class='fa fa-angle-left'></i>",
          "<i class='fa fa-angle-right'></i>"
        ],
    });

    $("#similar-slider").owlCarousel({
        navigation: true, 
        navigationText: ["<i class='fa fa-angle-left'></i>","<i class='fa fa-angle-right'></i>"],
        slideSpeed : 600,
        autoPlay : 8000,
        items : 3,
        itemsDesktop      : [1199,2],
        itemsDesktopSmall     : [979,2],
        itemsTablet       : [768,2],
        itemsMobile       : [479,1],
        pagination: false
    });
    $("#histories").owlCarousel({
        navigation: true, 
        navigationText: ["<i class='fa fa-angle-left'></i>","<i class='fa fa-angle-right'></i>"],
        slideSpeed : 600,
        autoPlay : 8000,
        items : 4,
        itemsDesktop      : [1199,3],
        itemsDesktopSmall     : [979,3],
        itemsTablet       : [768,2],
        itemsMobile       : [479,1],
        pagination: false
    });
    //Accordion

    $(".accordion").smk_Accordion({
        closeAble: true
    });

    //Skills Counter

    jQuery(document).ready(function($){
        $('.counter-skills').counterUp({
            delay: 100,
            time: 3000
        });
    });

    jQuery(document).ready(function($){
        $(".progress-bar").loading();
        $('input').on('click', function() {
            $(".progress-bar").loading();
        });
    });
    
    //Sliders
    
    $("#awards").owlCarousel({
        navigation: true, 
        navigationText: ["<i class='fa fa-angle-left'></i>","<i class='fa fa-angle-right'></i>"],
        slideSpeed : 600,
        autoPlay : 8000,
        items : 3,
        itemsDesktop      : [1199,3],
        itemsDesktopSmall     : [979,2],
        itemsTablet       : [768,1],
        itemsMobile       : [479,1],
        pagination: false
    });

    $("#people").owlCarousel({
        navigation: true, 
        navigationText: ["<i class='fa fa-angle-left'></i>","<i class='fa fa-angle-right'></i>"],
        slideSpeed : 600,
        autoPlay : 8000,
        items : 2,
        itemsDesktop      : [1199,2],
        itemsDesktopSmall     : [979,2],
        itemsTablet       : [768,2],
        itemsMobile       : [479,1],
        pagination: false
    });

    $("#clients").owlCarousel({
        navigation: true, 
        navigationText: ["<i class='fa fa-angle-left'></i>","<i class='fa fa-angle-right'></i>"],
        slideSpeed : 600,
        autoPlay : 8000,
        items : 5,
        itemsDesktop      : [1199,5],
        itemsDesktopSmall     : [979,4],
        itemsTablet       : [768,3],
        itemsMobile       : [479,2],
        pagination: false
    });

    //Back To Top
    $('#to-top').on('click',function() {
        $("html, body").animate({ scrollTop: 0 }, 600);
        return false;
    });


})(jQuery);