(function(){

    var app = angular.module('virada');
    var conf = GlobalConfiguration;

    app.controller('SpacesFilter',[ '$scope', 'THEME_DIR',
        function SpacesFilterCtrl($scope, THEME_DIR) {
            $scope.map = {
                center: {
                    latitude: -23.524001004591987,
                    longitude: -46.669245947265615
                },
                control: {},
                zoom: 14
            };

            $scope.icons = {
                'default': THEME_DIR + 'img/pin.png',
                'selected': THEME_DIR + 'img/pin-selected.png'
            }

            $scope.countSelected = function(){
                return $scope.spaces.filter(function(space){
                    return space.selected === true;
                }).length;
            };

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
