
document.addEventListener('keyup', function(e){
    if(e.ctrlKey && e.keyCode == 32){
       jQuery('.panel-collapse').collapse('show');
       console.log('toggling collapsible... \n catch that fire!')
    }
});

document.addEventListener('keyup', function(e){
    if(e.ctrlKey && e.shiftKey && e.keyCode == 32){
       jQuery('.event-content').height('153px').css('background-color', 'none')
       .css('background','linear-gradient(to bottom, rgba(137,52,148,0) 0%,rgba(137,52,148,0.32) 62%,rgba(214,46,122,0.42) 81%,rgba(230,45,117,1) 85%,rgba(238,44,114,1) 87%,rgba(238,44,114,1) 89%,rgba(238,44,114,0.72) 100%)')
       .find('h1').css({'padding-top': '15px', 'text-shadow': '2px 2px black'})
            .hover(function(){jQuery(this).css('text-decoration', 'underline')}).mouseleave(function(){jQuery(this).css('text-decoration', 'none')}).show();
       jQuery('.event-content').find('footer').css({'bottom': '5px', 'text-shadow': '1px 1px black'});
    }
});



var app = angular.module('virada', ['google-maps']);

app.controller('main', function($scope){
    $scope.conf = GlobalConfiguration;

    $scope.brDate = function(date){
        return moment(date).format('dddd[,] DD [de] MMMM [de] YYYY');
    };

    $scope.eventUrl = function(eventId){
        return $scope.conf.baseURL + '/programacao/atracao/##' + eventId;
    };

    $scope.spaceUrl = function(spaceId){
        return $scope.conf.baseURL + '/programacao/local/##' + spaceId;
    };
});

app.controller('evento', function($scope, $http, $location, $timeout, DataService){

    $scope.event = null;
    $scope.space = null;

    var eventId = parseInt($location.$$hash);

    $http.get($scope.conf.templateURL+'/app/events.json').success(function(data){
        data.some(function(e){
            if(e.id == eventId){
                $scope.event = e;
                DataService.getSpaces().then(function(response){
                    response.data.some(function(e){
                        if(e.id == $scope.event.spaceId){
                            $scope.space = e;
                            return true;
                        }
                    });
                });
                return true;
            }
        });
    });


});

app.controller('espaco', function($scope, $http, $location, $timeout, DataService){

    $scope.space = null;
    $scope.spaceEvents = [];

    var spaceId = parseInt($location.$$hash);

    $http.get($scope.conf.templateURL+'/app/events.json').success(function(data){

        data.forEach(function(e){
            if(e.spaceId == spaceId){
                $scope.spaceEvents.push(e);
            }
        });
    });

    DataService.getSpaces().then(function(response){
        response.data.some(function(e){
            if(e.id == spaceId){
                $scope.space = e;
                return true;
            }
        });
    });

});


app.controller('programacao', function($scope, $http, $location, $timeout, DataService){
    $scope.events = null;
    $scope.spaces = null;

    $scope.eventIndex = null;
    $scope.eventIndexByName = null;

    $scope.viewMode = 'grid';
    $scope.searchText = '';

    $scope.startsAt = '18:00';
    $scope.endsAt = '18:00';

    $scope.conf = GlobalConfiguration;

    $scope.filters = {
        'spaces': false
    };

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


    DataService.getSpaces().then(function(response){
        var data = response.data;
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

    $http.get($scope.conf.templateURL+'/app/events.json').success(function(data){
        $scope.eventsById = {};

        $scope.events = data;

        $scope.eventIndex = data.map(function(e,i){
            $scope.eventsById[e.id] = e;

            return {
                text: $scope.unaccent(e.name + e.shortDescription),
                startsAt : getTime(e.startsAt),
                getEntity: function (){ return e; }
            };


        });

        $scope.eventIndexByName = $scope.eventIndex.slice().sort(function(a,b){
            if(a.text > b.text)
                return 1;
            else if(a.text < b.text)
                return -1;
            else
                return 0;
        });



        $scope.populateEntities();
    });

    $scope.changeStartsAt = function (){
        var start = parseInt($scope.startsAt.replace(':', ''));
        var end = parseInt($scope.endsAt.replace(':', ''));
        if(start < 1800 && start > 1700){
            $scope.startsAt = '17:00';
            $scope.endsAt = '18:00';
        }else if(start < 1800 && end < start + 100){
            var startSplit = $scope.startsAt.split(':');
            startSplit[0]++;
            $scope.endsAt = startSplit.join(':');
        }

        $scope.populateEntities();
    };

    $scope.changeEndsAt = function (){
        var start = parseInt($scope.startsAt.replace(':', ''));
        var end = parseInt($scope.endsAt.replace(':', ''));

        if(start < 1800 && start > 1700){
            $scope.startsAt = '17:00';
            $scope.endsAt = '18:00';
        }else if(getTime($scope.endsAt) - getTime($scope.startsAt) <= 100){
            var endSplit = $scope.endsAt.split(':');
            endSplit[0] = endSplit[0] == 0 ? '23' : endSplit[0]-1;

            $scope.startsAt = endSplit.join(':');
        }

        $scope.populateEntities();
    };

    function getTime(time){
        var t = parseInt(time.replace(':', ''));
        if(t < 1800)
            return t + 20000;
        else
            return t + 10000;
    }

    $scope.searchResult = [];

    $scope.populateEntities = function(){
        if(!$scope.events || !$scope.spaces)
            return;

        if($scope.searchTimeout)
            $timeout.cancel($scope.searchTimeout);


        $scope.searchTimeout = $timeout(function(){
            var searchResultBySpaceId = {};
            var txt = $scope.unaccent($scope.searchText);
            var searchStartsAt = getTime($scope.startsAt);
            var searchEndsAt = $scope.endsAt === '18:00' ? getTime('17:59') : getTime($scope.endsAt);

            var events = [];
            var spaces = [];

            $scope.searchResult = [];

            $scope.eventIndex.forEach(function(event){
                if(event && (txt.trim() === '' || event.text.indexOf(txt) >= 0)
                && event.startsAt <= searchEndsAt  &&  event.startsAt >= searchStartsAt)
                    events.push(event.getEntity());
            });

            events.forEach(function(event){
                var space = $scope.spacesById[event.spaceId];
                if(space && spaces.indexOf(space) < 0)
                    spaces.push(space);
            });

            spaces.forEach(function(e){
                var space = angular.copy(e);
                space.isSelected = function(){ return e.selected; };
                space.events = [];
                $scope.searchResult.push(space);
                searchResultBySpaceId[space.id] = space;
            });

            events.forEach(function(event){
                searchResultBySpaceId[event.spaceId].events.push(event);
            });

        },10);
    };
});