(function(){

    var app = angular.module('virada');
    var conf = GlobalConfiguration;

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

            $scope.icons = {
                'default': 'http://mt.googleapis.com/vt/icon/name=icons/spotlight/spotlight-waypoint-b.png',
                'selected': 'http://mt.googleapis.com/vt/icon/name=icons/spotlight/spotlight-poi.png'
            }

            $scope.spaces = [];
            DataService.getSpaces()
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
            };

            $scope.hideSpaceInfo = function(space) {
                space.showInfo = false;
            };

            $scope.toggleSelectSpace = function(space) {
                space.selected = !space.selected;
            };
            
            $scope.deselectAll = function(){
                $scope.spaces.forEach(function(s){ s.selected = false; });
            };
        }
    ]);

})(window.angular);
