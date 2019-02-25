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
/*
	dotcount = 1;
	
	jQuery('.owl-dot').each(function() {
		jQuery( this ).addClass( 'dotnumber' + dotcount);
		jQuery( this ).attr('data-info', dotcount);
		dotcount=dotcount+1;
	});
	
	slidecount = 1;
	
	jQuery('.owl-item').not('.cloned').each(function() {
		jQuery( this ).addClass( 'slidenumber' + slidecount);
		slidecount=slidecount+1;
	});
	
	jQuery('.owl-dot').each(function() {	
		grab = jQuery(this).data('info');		
		slidegrab = jQuery('.slidenumber'+ grab +' img').attr('src');
		jQuery(this).css("background-image", "url("+slidegrab+")");  	
	});
	
	amount = $('.owl-dot').length;
	gotowidth = 100/amount;			
	jQuery('.owl-dot').css("height", gotowidth+"%");
  */
  
});