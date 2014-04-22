
document.addEventListener('keyup', function(e){
    if(e.ctrlKey && e.keyCode == 32){
       jQuery('.panel-collapse').collapse('toggle');
       //console.log('toggling collapsible... \n catch that fire!')
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

var imgLazyLoad = {
    timeouts: [],

    init: function(){
        jQuery("img.lazy").each(function(){
            var $this = jQuery(this);
            imgLazyLoad.timeouts.push(setTimeout(function(){
                $this.attr('src', $this.data('original'));
            }));
        });
    },

    clear: function(){
        imgLazyLoad.timeouts.forEach(function(e){
            clearTimeout(e);
        });

        this.timeouts = [];
    }
};

var app = angular.module('virada', ['google-maps','ui-rangeSlider']);

app.directive('onLastRepeat', function() {
    return function(scope, element, attrs) {
        if (scope.$last) setTimeout(function(){
            scope.$emit('onRepeatLast', element, attrs);
        }, 1);
    };
});


app.controller('main', function($scope, $window){
    $scope.conf = GlobalConfiguration;

    $scope.winWidth = function(){
        return $window.innerWidth;
    };

    $scope.$on('onRepeatLast', function(scope, element, attrs){
        hl.carrousel.init();
        minhaVirada.atualizaEstrelas();

        imgLazyLoad.init();
    });

    $scope.brDate = function(date){
        return moment(date).format('dddd[,] DD [de] MMMM [de] YYYY');
    };

    $scope.eventUrl = function(eventId){
        return $scope.conf.baseURL + '/programacao/atracao/##' + eventId;
    };

    $scope.spaceUrl = function(spaceId){
        return $scope.conf.baseURL + '/programacao/local/##' + spaceId;
    };

    $scope.favorite = function(eventId){
        minhaVirada.click(eventId);
    };

    $scope.getSelectedIds = function(array){
        var result = array.filter(function(value,index){
            return value.selected;
        });
        return result.map(function(e){return parseInt(e.id)})
    };

    window.fbAsyncInit = function() {
        FB.init({
        appId      : '1460336737533597',
        status     : false,
        xfbml      : true
        });

        // ao carregar a pagina vemos se o usuario ja esta conectado e com o app autorizado.
        // se nao estiver, não fazemos nada. Só vamos fazer alguma coisa se ele clicar
        FB.getLoginStatus(function(response) {
            if (response.status === 'connected') {
                minhaVirada.initializeUserData(response, false);
                $scope.connected = true;
                $scope.$emit('fb_connected', response.authResponse.userID);
            }
        });

    };

    (function(d, s, id){
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {return;}
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/pt_BR/all.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));

});

app.controller('evento', function($scope, $http, $location, $timeout, DataService){

    $scope.event = null;
    $scope.space = null;
    $scope.mapUrl = null
    var eventId = parseInt($location.$$hash);

    $http.get($scope.conf.templateURL+'/app/events.json').success(function(data){
        data.some(function(e){
            if(e.id == eventId){
                $scope.event = e;
                DataService.getSpaces().then(function(response){
                    response.data.some(function(e){
                        if(e.id == $scope.event.spaceId){
                            $scope.space = e;
                            $scope.mapUrl = "https://maps.google.com/maps?hl=pt-BR&amp;geocode=&amp;q=" + e.name + ", " + e.endereco + ", São Paulo - SP, Brasil&amp;sll=" + e.location.latitude + "," + e.location.longitude + "&amp;ie=UTF8&amp;hq=Teatro Municipal, Praça Ramos de Azevedo, s/n - Republica São Paulo - SP 01037-010, Brasil&amp;hnear=&amp;radius=15000&amp;t=m&amp;ll=" + e.location.latitude + "," + e.location.longitude + "&amp;z=17&amp;output=embed&amp;iwloc=near&amp;language=pt-BR&amp;region=br";
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


app.controller('programacao', function($scope, $http, $location, $timeout, $window, DataService){
    $scope.events = null;
    $scope.spaces = null;
    $scope.spacesByName = null;

    $scope.eventIndex = null;

    $scope.viewByLabels = {
        'space': 'Local',
        'name': 'Atração',
        'time': 'Horário'
    };
    $scope.viewBy = 'space';
    $scope.smallDevice = $window.innerWidth < 992;
    $scope.viewMode = $scope.smallDevice ? 'list' : 'grid';
    $scope.searchText = '';

    $scope.startsAt = '18:00';
    $scope.endsAt = '18:00';

    $scope.conf = GlobalConfiguration;

    $scope.filters = {
        'spaces': false
    };

    $scope.timeSlider = {
        range: {
            min: 0,
            max: 96
        },
        model:{
            min:0,
            max:96
        },
        time:{
            min: '18:00',
            max: '17:59'
        }
    };

    $scope.slideTimeout = null;

    $scope.win = $window;

    $scope.setViewMode = function(mode){
        $scope.viewMode = mode;
    };

    $scope.setViewBy = function(by){
        $scope.viewBy = by;
    };

    $scope.setSearchText = function(elementId){
        $scope.searchText = document.getElementById(elementId).value;
    };

    angular.element($window).bind('resize', function(){
        if($window.innerWidth < 992){
            $scope.viewMode = 'list';
            $scope.smallDevice = true;
        }else{
            $scope.smallDevice = false;
        }
        $scope.$apply();
    });

    $scope.$watch('timeSlider.model.min', function(){
        $scope.startsAt = moment('2014-05-17 18:00').add('minutes', $scope.timeSlider.model.min * 15).format('H:mm');
        $scope.populateEntities();
    });

    $scope.$watch('timeSlider.model.max', function(){
        $scope.endsAt = moment('2014-05-17 18:00').add('minutes', $scope.timeSlider.model.max * 15).format('H:mm');
        $scope.populateEntities();
    });

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
                entity: e
            };
        });

        $scope.spacesByName = $scope.spaces.slice().sort(function(a,b){
            if(a.name > b.name)
                return 1;
            else if(a.name < b.name)
                return -1;
            else
                return 0;
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
                entity: e
            };


        });

        $scope.populateEntities();
    });

    function getTime(time){
        var t = parseInt(time.replace(':', ''));
        if(t < 1800)
            return t + 20000;
        else
            return t + 10000;
    }

    $scope.searchResult = [];
    $scope.searchResultEventsByTime = [];
    $scope.searchResultEventsByName = [];

    $scope.populateEntities = function(delay){
        if(!$scope.events || !$scope.spaces)
            return;

        delay = delay || 300;

        if($scope.searchTimeout)
            $timeout.cancel($scope.searchTimeout);


        $scope.searchTimeout = $timeout(function(){
            imgLazyLoad.clear();

            var searchResultBySpaceId = {};
            var txt = $scope.unaccent($scope.searchText);
            var searchStartsAt = getTime($scope.startsAt);
            var searchEndsAt = $scope.endsAt === '18:00' ? getTime('17:59') : getTime($scope.endsAt);

            var events = [];
            var spaces = [];

            $scope.searchResult = [];

            $scope.eventIndex.forEach(function(event){
                if(event && (txt.trim() === '' || event.text.indexOf(txt) >= 0) && event.startsAt <= searchEndsAt  &&  event.startsAt >= searchStartsAt){
                    if(!$scope.filters.spaces || $scope.spacesById[event.entity.spaceId].selected)
                        events.push(event.entity);
                }
            });

            $scope.searchResultEventsByTime = events;

            $scope.searchResultEventsByName = events.slice().sort(function(a,b){
                if(a.name > b.name)
                    return 1;
                else if(a.name < b.name)
                    return -1;
                else
                    return 0;
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

        }, delay);

    };
});

app.controller('minha-virada', function($rootScope, $scope, $http, $location, $timeout, DataService){

    $scope.hasEvents = false;
    $scope.userEvents = [];
    $scope.user_name = 'Minha Virada';
    $scope.connected = false;
    $scope.home = true; // não estou vendo perfil de ninguém
    $scope.itsme = false;

    var $myscope = $scope;

    $rootScope.$on('fb_connected', function(ev, uid) {
        $scope.connected = true;

        $scope.home = false;


        if ($location.$$hash) {
            if ($location.$$hash == uid) {

                $scope.itsme = true;
                $scope.$apply();
            }
            return;
        }

        $scope.itsme = true;

        $scope.$apply();

        $scope.loadUserData(uid);
        $location.hash(uid);


    });

    $scope.loadUserData = function(uid) {
        $http.get($scope.conf.baseURL+'/wp-content/uploads/minha-virada/'+uid).success(function(data){
            $scope.populateUserInfo(data);
        });
    }

    $scope.populateUserInfo = function(data) {

        $scope.user_picture = data.picture;
        $scope.user_name = data.name;

        $http.get($scope.conf.templateURL+'/app/events.json').success(function(allEvents){

            allEvents.forEach(function(e){
                if (data.events && data.events.length > 0) {
                    $scope.hasEvents = true
                    for (var i = 0; i < data.events.length; i++) {
                        if(e.id == data.events[i]) {
                            $scope.userEvents.push(e);
                            break;
                        }
                    }
                }

            });

        });

    }

    if ($location.$$hash) {
        $scope.home = false;
        $scope.loadUserData($location.$$hash);
    }



});
