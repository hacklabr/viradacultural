(function($){
	$(document).ready(function(){

		$('.btn-sm span').tooltip();

		$('.collapse').collapse();

		$('#front-page-carousel .item:first, .carousel-indicators li:first').addClass('active');
		$('#front-page-carousel').carousel();
        
        // MENU ANIMATION
        
	})
})(jQuery);