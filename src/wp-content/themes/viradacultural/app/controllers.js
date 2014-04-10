(function(){

    var app = angular.module('virada');

    app.controller('SpacesFilter',[ '$scope', 'DataService',
        function SpacesFilterCtrl($scope, DataService) {
            $scope.map = {
                center: {
                    latitude: -23.524001004591987,
                    longitude: -46.669245947265615
                },
                control: {},
                zoom: 14
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

            $scope.showSpaceInfo = function(space) {
                $scope.spaces.forEach(function(s){ s.showInfo = false; });
                space.showInfo = true;
            }
            $scope.hideSpaceInfo = function(space) {
                space.showInfo = false;
            }
        }
    ]);

})(window.angular);
