$('.page-slider').each(function() {
  var $slider =  $(this);
  var numberOfSlides = $slider.find('.page-panel').length;
  
  $slider.find('.page-panel:eq(0)').addClass('_active');
  $slider.find('.nav-dot:eq(0)').addClass('active');
  
  var $activeSlide = $slider.find('.page-panel._active');
  var $nextBtn = $slider.find('.next-btn');
  var $prevBtn = $slider.find('.prev-btn');
  
  $('.nav-dot').on('click', function() {
    var slideToGo = $(this).data('slide');
    goToSlide(slideToGo);
  });
  
  
  $slider.on('slide.changed', function() {
    console.log('slide changed !');
    $('.nav-dot').removeClass('active');
    var $activeDot = $('.nav-dot[data-slide="'+$('.page-panel._active').data('slide')+'"]');
    $activeDot.addClass('active');
  });
  
  $nextBtn.on('click', function(event) {
    nextSlide();
  });
  
  $prevBtn.on('click', function(event) {
    prevSlide();
  });
  

  function nextSlide() {
    $activeSlide = $slider.find('.page-panel._active');
    var $nextSlide = $activeSlide.next('.page-panel');
    $activeSlide.removeClass('_active');
    $nextSlide.addClass('_active');
    
    //$activeSlide = $nextSlide;
    
    var slideIndex = $slider.find('.page-panel._active').index('.page-panel');
    console.log(slideIndex);
    
    
    if(slideIndex >= numberOfSlides || slideIndex <= -1 ) {
      firstSlide();
      $slider.trigger('slide.changed');  
      
    }else {
      $slider.trigger('slide.changed');  
    }
    
  } 
  
function prevSlide() {
    $activeSlide = $slider.find('.page-panel._active');
  
    var $prevSlide = $activeSlide.prev('.page-panel');
    //console.log($prevSlide);
    $activeSlide.removeClass('_active');
    $prevSlide.addClass('_active');
    //$activeSlide = $prevSlide;
    
    var slideIndex = $slider.find('.page-panel._active').index();
    console.log(slideIndex);
    
    
  
    if(typeof $prevSlide === 'undefined'|| $prevSlide === null || $prevSlide.length == -1 || slideIndex <= -1 ) {
      lastSlide();
      $slider.trigger('slide.changed');
    } else {
      $slider.trigger('slide.changed');  
    }
    
  } 
  
  function firstSlide() {
      $('.page-panel._active').removeClass('_active');
      $slider.find('.page-panel:eq(0)').addClass('_active');
      $activeSlide = $slider.find('.page-panel:eq(0)');
      
  }
  
    function lastSlide() {
      //console.log('last');
      $('.page-panel._active').removeClass('_active');
      $slider.find('.page-panel').eq(numberOfSlides-1).addClass('_active');
      //$activeSlide = $slider.find('.panel:eq(numberOfSlides)');

  }
  
  function goToSlide(slideToGo) {
      $('.page-panel._active').removeClass('_active');
      $slider.find('.page-panel').eq(slideToGo -1).addClass('_active');
      $activeSlide = $slider.find('.page-panel').eq(slideToGo -1).addClass('_active');
      $slider.trigger('slide.changed');  
  }
    
});