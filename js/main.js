jQuery(document).ready(function($) {

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
 
  function fit() {
    if($( window ).width() < 1000){
      var height = $( window ).height() - $('nav.logo-navigation').height();
      $('#navigation').height(height);      
    } else $('#navigation').height('auto');
  }
  
	$(window).load(fit);
	$(window).resize(fit);  
});