(function(){

    var app = angular.module('virada');

    app.directive('modalShown', function(){
        return {
            'restrict': 'A',
            'scope':{ 'modalShown': '&'},
            'link': function(scope, element, attrs) {
                // Watch ui-refresh and refresh the directive
                element.on('shown.bs.modal', scope.modalShown);
            }
        };
    });

})(window.angular);
