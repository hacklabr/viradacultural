(function(){

    var app = angular.module('virada');
    var conf = GlobalConfiguration;

    app.controller('SpacesFilter',[ '$scope', '$rootScope', '$timeout',
        function SpacesFilterCtrl($scope, $rootScope, $timeout) {
            $scope.spaces = [];
            $scope.plottingMap = true;

            $scope.$on('onRepeatLast', function(scope, element, attrs){
                $scope.plottingMap = false;
                $scope.redrawMap();
            });

            $scope.map = {
                center: {
                    latitude: -23.524001004591987,
                    longitude: -46.669245947265615
                },
                control: {},
                zoom: 14
            };

            $scope.marker = {
                icon: {
                    'default': GlobalConfiguration.templateURL + '/img/pin.png',
                    'selected': GlobalConfiguration.templateURL + '/img/pin-selected.png',
                    'nearMe' :  GlobalConfiguration.templateURL + '/img/pin-mim.png'
                },
                options: {
                    'shadow': GlobalConfiguration.templateURL + '/img/pin-shadow.png'
                }
            };

            $scope.infowindow = {
                options: {
                    pixelOffset: new google.maps.Size(0, -40)
                }
            };

            //Exports this settings to the root scope
            $rootScope.map = $scope.map;
            $rootScope.marker = $scope.marker;
            $rootScope.infowindow = $scope.infowindow;

            $scope.countSelected = function(){
                return $scope.spaces.filter(function(space){
                    return space.selected === true;
                }).length;
            };

            $scope.redrawMap = function(){
                var gmap = $scope.map.control.getGMap();
                google.maps.event.trigger(gmap, 'resize');

                if($scope.spaces && $scope.spaces.length > 0) return;
                $scope.spaces = $scope.$parent.spaces;
            };

            $scope.showSpaceInfo = function(space) {
                $scope.spaces.forEach(function(s){ s.showInfo = false; });
                space.showInfo = true;
                if($rootScope.filterNearMe.infoWindow)
                    $rootScope.filterNearMe.infoWindow.setMap(null);
            };

            $scope.hideSpaceInfo = function(space) {
                space.showInfo = false;
            };

            var toggleSelectSpace = function(space) {
                space.selected = !space.selected;
            };
            $scope.toggleSelectSpace = toggleSelectSpace;


            $scope.deselectAll = function(){
                $scope.spaces.forEach(function(s){ s.selected = false; });
            };

            /**
             * Não estou conseguindo colocar um callback dentro do elemento
             * <window /> que é da lib angular-google-maps. Então para fazer
             * o botão selectionar, fiz a engenhoca abaixo.
             */
            jQuery(document.body).on('click', '[fl-space-id]', function(){
                var id = parseInt(jQuery(this).attr('fl-space-id'), 10);
                var space;
                for(var i=0; i < $scope.spaces.length; i++) {
                    if($scope.spaces[i].id === id){
                        space = $scope.spaces[i];
                    }
                }
                if( !space ) { return; }

                var list = jQuery('#fl-list-spaces');
                var listItem = list.find('#fl-list-item-' + id);
                var offsetTop = listItem.get(0).offsetTop - list.height() / 3;

                $scope.$apply(function(){
                    toggleSelectSpace(space);
                    if(space.selected){
                        list.animate({scrollTop: offsetTop});
                    }
                });
            });
        }
    ]);

})(window.angular);
