jQuery(document).ready(function($) {
    //mobile menu
  $('.mobile-menu').on('click', function(){
    $('#main-menu').toggleClass('open');
    $('.mobile-menu').toggleClass('open');
  });
  
  $('.change-language').on('click', function(){
    $('.mobile-language .language-switcher-locale-url').toggleClass('open');
  }); 
  
  /* dropdown
  $('#main-menu ul li a span.arrow-down').on('click', function(e){
    e.preventDefault();
    $(this).parent().parent().toggleClass('open');
  });
  */
  function fit() {
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