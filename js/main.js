(function ($, Drupal) {
  Drupal.behaviors.gftheme = {
    attach: function (context, settings) {
      $('#block-views-exp-products-novelty .views-exposed-form label,#block-views-exp-products-main-catalog .views-exposed-form label').on('click', function(){
        if(!$(this).parent().children('.views-widget').hasClass('open'))
          $('#block-views-exp-products-novelty .views-exposed-form .views-widget,#block-views-exp-products-main-catalog .views-exposed-form .views-widget').removeClass('open');
        $(this).parent().children('.views-widget').toggleClass('open');
      });
    }
  };
})(jQuery, Drupal);

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
        if ($(this).scrollTop()>1){
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
  $('.owl-carousel .owl-thumb-item').hover(function() {
    $(this).click();
  }, function() {});

  //http://www.jacklmoore.com/zoom/
  $(".owl-stage-outer .item").zoom({
    magnify:'0.5',
    callback: function(){
      $(this).colorbox({href: this.src,maxWidth:'95%', maxHeight:'95%'});
    }
  });  
  
  var thumbscount = $('.node-product .owl-thumbs .owl-thumb-item').length;
  var current = 0;
  $('.node-product .owl-thumbs').before('<div class="owl-thumbs-prev">▲</div>');
  $('.node-product .owl-thumbs').after('<div class="owl-thumbs-next">▼</div>');
  
  $('.node-product .owl-carousel .owl-thumbs-prev').on('click', function() {
    if (current > 0) current = current - 1;
    var elheight = $('.node-product .owl-carousel .owl-thumb-item').height() + parseInt($('.node-product .owl-carousel .owl-thumb-item').css("margin-bottom"))+ parseInt($('.node-product .owl-carousel .owl-thumb-item').css("padding-top"))+ parseInt($('.node-product .owl-carousel .owl-thumb-item').css("padding-bottom"));
    $('.node-product .owl-carousel .owl-thumbs').css('margin-top',(-1)*elheight*current);
  });
  $('.node-product .owl-carousel .owl-thumbs-next').on('click', function() {
    if (current < thumbscount-3) current = current + 1;
    var elheight = $('.node-product .owl-carousel .owl-thumb-item').height() + parseInt($('.node-product .owl-carousel .owl-thumb-item').css("margin-bottom"))+ parseInt($('.node-product .owl-carousel .owl-thumb-item').css("padding-top"))+ parseInt($('.node-product .owl-carousel .owl-thumb-item').css("padding-bottom"));
    $('.node-product .owl-carousel .owl-thumbs').css('margin-top',(-1)*elheight*current);
  });  
  
  //tabs
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