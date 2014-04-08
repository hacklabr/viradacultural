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
        
        // TOGGLE VIEW
        $("#grid-view").click(
            function() {
                $(".event").removeClass("event-list").addClass("event-grid");
                $(".program-nav").show();
                $(this).addClass("active");
                $("#list-view").removeClass("active");
            }
        );
        $("#list-view").click(
            function() {
                $(".event").removeClass("event-grid").addClass("event-list");
                $(".program-nav").hide();
                $(this).addClass("active");
                $("#grid-view").removeClass("active");
            }
        )

        $(".page-template-page-dez-anos-php > #main-header").removeClass().addClass("col-md-1");
    })
})(jQuery);