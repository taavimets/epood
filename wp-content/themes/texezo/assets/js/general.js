// JavaScript Document
jQuery(document).ready(function() {
	
	var texezoViewPortWidth = '',
		texezoViewPortHeight = '';

	function texezoViewport(){

		texezoViewPortWidth = jQuery(window).width(),
		texezoViewPortHeight = jQuery(window).outerHeight(true);	
		
		if( texezoViewPortWidth > 1200 ){
			
			jQuery('.main-navigation').removeAttr('style');
			
			var texezoSiteHeaderHeight = jQuery('.site-header').outerHeight();
			var texezoSiteHeaderWidth = jQuery('.site-header').width();
			var texezoSiteHeaderPadding = ( texezoSiteHeaderWidth * 2 )/100;
			var texezoMenuHeight = jQuery('.menu-container').height();
			
			var texezoMenuButtonsHeight = jQuery('.site-buttons').height();
			
			var texezoMenuPadding = ( texezoSiteHeaderHeight - ( (texezoSiteHeaderPadding * 2) + texezoMenuHeight ) )/2;
			var texezoMenuButtonsPadding = ( texezoSiteHeaderHeight - ( (texezoSiteHeaderPadding * 2) + texezoMenuButtonsHeight ) )/2;
		
			
			jQuery('.menu-container').css({'padding-top':texezoMenuPadding});
			jQuery('.site-buttons').css({'padding-top':texezoMenuButtonsPadding});
			
			
		}else{

			jQuery('.menu-container, .site-buttons, .header-container-overlay, .site-header').removeAttr('style');

		}	
	
	}

	jQuery(window).on("resize",function(){
		
		texezoViewport();
		
	});
	
	texezoViewport();


	jQuery('.site-branding .menu-button').on('click', function(){
				
		if( texezoViewPortWidth > 1200 ){

		}else{
			jQuery('.main-navigation').slideToggle();
		}				
		
				
	});	

    var owl = jQuery("#texezo-owl-basic");
         
    owl.owlCarousel({
             
      	slideSpeed : 300,
      	paginationSpeed : 400,
      	singleItem:true,
		navigation : true,
      	pagination : false,
      	navigationText : false,
         
    });			
	
});		