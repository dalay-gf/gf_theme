jQuery(document).ready(function($) {
    //mobile menu
  $('.mobile-menu').on('click', function(){
    $('#navigation').toggleClass('open');
    $('.mobile-menu').toggleClass('open');
  });
  
  $('.change-language').on('click', function(){
    $('.mobile-language .language-switcher-locale-url').toggleClass('open');
  }); 
  
  $('.language-trio, .language-languages .language-switcher-locale-url li.active').on('click', function(e){
    e.preventDefault();
    $('.language-languages').toggleClass('open');
  });
  
  $('.mobile-search-icon').on('click', function(){
    $('#block-views-exp-search-results-page').toggleClass('open');
  });   
  
  $(window).scroll(function() {
      if ($( window ).width() > 999){
        if ($(this).scrollTop()>120){
          $('#logo').hide();
          $('.mobile-cart').show();
        }
        else{
          $('#logo').show();
          $('.mobile-cart').hide();
        }          
      }


       
   });
 
  /* dropdown
  $('#main-menu ul li a span.arrow-down').on('click', function(e){
    e.preventDefault();
    $(this).parent().parent().toggleClass('open');
  });
  */
  function fit() {
    if($( window ).width() < 1000){
      var height = $( window ).height() - $('nav.logo-navigation').height();
      $('#navigation').height(height);      
    } else $('#navigation').height('auto');

    if ($( window ).width() > 999){ //part for big tablets
      $( '#main-menu' ).removeClass('open');
      $( '#main-menu li' ).removeClass('open');
      $('.mobile-menu').removeClass('open');
      $( '#main-menu ul.menu li ul.menu li ul' ).removeClass('menu');
      $( '#main-menu ul.menu li ul.menu li ul' ).addClass('menu1');
      //$( '#main-menu li:has(ul.menu)' ).doubleTapToGo();
    }    
  }
	$(window).load(fit);
	$(window).resize(fit);  
});