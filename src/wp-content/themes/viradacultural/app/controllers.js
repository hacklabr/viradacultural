(function(){

    var app = angular.module('virada');

    app.controller('SpacesFilter',[ '$scope',
        function SpacesFilterCtrl($scope) {
            $scope.map = {
                center: {
                    latitude: 45,
                    longitude: -73
                },
                control: {},
                zoom: 8
            };

            $scope.redrawMap = function(){
                var gmap = $scope.map.control.getGMap()
                google.maps.event.trigger(gmap, 'resize')
            };
        }
    ]);

})(window.angular);
