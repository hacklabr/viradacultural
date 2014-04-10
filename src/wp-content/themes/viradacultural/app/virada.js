var app = angular.module('virada', ['google-maps']);

app.controller('main', function($scope, $http, $location, $timeout){
    $scope.events = null;
    $scope.spaces = null;

    $scope.viewMode = 'grid';
    $scope.searchText = '';
    /**
     *
     * @param {type} s
     * @returns {String}
     */
    $scope.unaccent = function(s) {
        var r = s.toLowerCase();
        r = r.replace(new RegExp("\\s", 'g'), "");
        r = r.replace(new RegExp("[àáâãäå]", 'g'), "a");
        r = r.replace(new RegExp("æ", 'g'), "ae");
        r = r.replace(new RegExp("ç", 'g'), "c");
        r = r.replace(new RegExp("[èéêë]", 'g'), "e");
        r = r.replace(new RegExp("[ìíîï]", 'g'), "i");
        r = r.replace(new RegExp("ñ", 'g'), "n");
        r = r.replace(new RegExp("[òóôõö]", 'g'), "o");
        r = r.replace(new RegExp("œ", 'g'), "oe");
        r = r.replace(new RegExp("[ùúûü]", 'g'), "u");
        r = r.replace(new RegExp("[ýÿ]", 'g'), "y");
        r = r.replace(new RegExp("\\W", 'g'), "");
        return r;
    };


    $http.get(GlobalConfiguration.templateURL+'/app/spaces.json').success(function(data){
        $scope.spaces = data;
        $scope.spacesById = {};

        $scope.spaceIndex = data.map(function(e,i){
            $scope.spacesById[e.id] = e;

            return {
                text: $scope.unaccent(e.name + e.shortDescription),
                getEntity: function (){ return e; }
            };
        });

        $scope.populateEntities();
    });

    $http.get(GlobalConfiguration.templateURL+'/app/events.json').success(function(data){
        $scope.events = data;
        $scope.eventsById = {};

        $scope.eventIndex = data.map(function(e,i){
            $scope.eventsById[e.id] = e;

            return {
                text: $scope.unaccent(e.name + e.shortDescription),
                getEntity: function (){ return e; }
            };
        });

        $scope.populateEntities();
    });

    $scope.$on('$locationChangeSuccess', function(){


    });


    $scope.searchResult = [];

    $scope.populateEntities = function(){
        if(!$scope.events || !$scope.spaces)
            return;

        if($scope.searchTimeout)
            $timeout.cancel($scope.searchTimeout);

        $scope.searchTimeout = $timeout(function(){
            var searchResultBySpaceId = {};
            var txt = $scope.unaccent($scope.searchText);
            var events = [];
            var spaces = [];
            $scope.searchResult = [];

            $scope.eventIndex.forEach(function(event){
                if(event && (txt.trim() === '' || event.text.indexOf(txt) >= 0))
                    events.push(event.getEntity());
            });

            events.forEach(function(event){
                var space = $scope.spacesById[event.spaceId];
                if(space && spaces.indexOf(space) < 0)
                    spaces.push(space);
            });

            spaces.forEach(function(e){
                var space = angular.copy(e);
                space.events = [];
                $scope.searchResult.push(space);
                searchResultBySpaceId[space.id] = space;
            });

            events.forEach(function(event){
                searchResultBySpaceId[event.spaceId].events.push(event);
            });
        },500);
    };
});