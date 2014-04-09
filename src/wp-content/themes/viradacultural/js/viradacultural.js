(function($){
    $(document).ready(function(){

        $('.btn-sm span').tooltip();

        $('.collapse').collapse();

        $('.timepicker-field').timepicker();

        $('#front-page-carousel .item:first, .carousel-indicators li:first').addClass('active');

        $('#front-page-carousel').carousel();

        // MENU ANIMATION
        // $("#main-header li.has-children").hover(
        //     function() {
        //         $("#main-header").removeClass().addClass("col-md-1");
        //     },
        //     function() {
        //         $("#main-header").removeClass().addClass("col-md-2");
        //     }
        // );

        $(".page-template-page-dez-anos-php > #main-header").removeClass().addClass("minified");

    })
})(jQuery);