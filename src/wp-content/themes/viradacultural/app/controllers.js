(function(){

    var app = angular.module('virada');

    app.controller('SpacesFilter',[ '$scope', 'DataService',
        function SpacesFilterCtrl($scope, DataService) {
            $scope.map = {
                center: {
                    latitude: 45,
                    longitude: -73
                },
                control: {},
                zoom: 8
            };

            $scope.spaces = [];
            DataService.search('qualquer-coisa')
                .then(function(result){
                    $scope.spaces = result.data;
                });

            $scope.redrawMap = function(){
                var gmap = $scope.map.control.getGMap()
                google.maps.event.trigger(gmap, 'resize')
            };
        }
    ]);

})(window.angular);
