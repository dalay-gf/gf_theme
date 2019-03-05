jQuery(document).ready(function($) {

  $('.mobile-menu').on('click', function(){
    $('#navigation').toggleClass('open');
    $('.mobile-menu').toggleClass('open');
  });
  
  $('ul.nav-menu li a span.arrow-down').on('click', function(e){
    e.preventDefault();
    $(this).parent().parent().toggleClass('open');
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
   
  $(".owl-carousel").owlCarousel({    
		items:1,
		margin:0,
		stagePadding: 0,
    thumbs: true,
    nav:true,
    dots:false,
		autoplay:false  
	});  
  
  $('ul.tabs__caption').on('click', 'li:not(.active)', function() {
  $(this)
    .addClass('active').siblings().removeClass('active')
    .closest('div.tabs').find('div.tabs__content').removeClass('active').eq($(this).index()).addClass('active');
  });
  
  $('.quantity [type="button"]').click(function() {
    var $qty = $(this).parent().find('.qty');
    var new_value = parseInt($qty.val()) + (($(this).val() == '◄' || $(this).val() == '-' || $(this).val() == '▼') ? -1 : +1);
    $qty.val(new_value < 1 ? 1 : new_value);
  });
  
  $('.accordion').accordion({
    active: false,
    collapsible: true
  });
  
});