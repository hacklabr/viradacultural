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
            };
            
            $scope.infowindow = {
                options: {
                    pixelOffset: new google.maps.Size(0, -40)
                }
            };

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
            if(jQuery) {
                jQuery(document.body).on('click', '[fl-space-id]', function(){
                    var id = parseInt(jQuery(this).attr('fl-space-id'), 10);
                    var space;
                    for(var i=0; i < $scope.spaces.length; i++) {
                        space = $scope.spaces[i];
                        if(space && space.id === id) {
                            $scope.$apply(function(){
                                toggleSelectSpace(space);
                            });
                        }
                    }
                })
            }
        }
    ]);

})(window.angular);
