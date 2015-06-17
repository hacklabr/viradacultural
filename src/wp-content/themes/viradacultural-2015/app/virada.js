
document.addEventListener('keyup', function(e){
    if(e.ctrlKey && e.keyCode == 32){
       jQuery('.panel-collapse').collapse('toggle');
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

var getMapUrl = function (spaceEntity){
    var e = spaceEntity;
    return "https://maps.google.com/maps?hl=pt-BR&geocode=&daddr=" + e.location.latitude + "," + e.location.longitude +"&sll=" + e.location.latitude + "," + e.location.longitude + "&ie=UTF8&hq=" + e.endereco + ",+São+Paulo,+SP,+Brasil&hnear=" + e.endereco + ",+São+Paulo,+SP,+Brasil&radius=15000&t=m&ll=" + e.location.latitude + "," + e.location.longitude + "&z=17&output=embed&iwloc=near&language=pt-BR&region=br";
};

var app = angular.module('virada', ['google-maps','ui-rangeSlider', 'angulartics', 'angulartics.google.analytics']);


app.directive('onFinishRender', function ($timeout) {
    return {
        restrict: 'A',
        link: function (scope, element, attr) {
            if (scope.$last === true) {
                $timeout(function () {
                    scope.$emit('ngRepeatFinished');
                });
            }
        }
    };
});
// app.config(function ($analyticsProvider) {
//     // turn off automatic tracking
//     $analyticsProvider.virtualPageviews(false);
// });  |

app.controller('main', function($scope, $rootScope, $window, $sce, $analytics){
    $scope.conf = GlobalConfiguration;
    $scope.current_share_url = document.URL.replace('##', '');

    $scope.eventTrack = function(label, options){
            $analytics.eventTrack(label, options);
            //console.log('EVENT TRACK ' , label, options);
    };

    $scope.pageTrack = function(virtualPath){
            $analytics.pageTrack(encodeURI(virtualPath));
            //console.log('PAGE VIEW ' , encodeURI(virtualPath));
    };

    $scope.getTrustedURI = function (URI){
        return $sce.trustAsResourceUrl(URI);
    };

    $scope.winWidth = function(){
        return $window.innerWidth;
    };

    $scope.brDate = function(date){
        return moment(date).format('dddd[,] DD [de] MMMM [de] YYYY');
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

    $rootScope.$on('minhavirada_hashchanged', function(ev, newurl) {
        $scope.current_share_url = newurl.replace('##', '');

    });

    window.fbAsyncInit = function() {
        FB.init({
            appId      : GlobalConfiguration.facebookAppId,
            xfbml      : true,
            version    : 'v2.3'
          });

        // ao carregar a pagina vemos se o usuario ja esta conectado e com o app autorizado.
        // se nao estiver, não fazemos nada. Só vamos fazer alguma coisa se ele clicar
        FB.getLoginStatus(function(response) {
            if (response.status === 'connected') {
                minhaVirada.initializeUserData(response, false);
                $scope.connected = true;
                $scope.$emit('fb_connected', response.authResponse.userID);
            }else{
                minhaVirada.initialized = true;
                minhaVirada.atualizaEstrelas();

                $scope.$emit('fb_not_connected');
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

    $http.get($scope.conf.templateURL+'/app/events.json?v=' + GlobalConfiguration.md5['events']).success(function(data){
        data.some(function(e){
            if(e.id == eventId){
                $scope.event = e;
                e.url = eventUrl(e.id);
                DataService.getSpaces().then(function(response){
                    response.data.some(function(e){
                        if(e.id == $scope.event.spaceId){
                            e.url = spaceUrl(e.id);
                            $scope.space = e;
                            $scope.mapUrl = getMapUrl(e);

                            return true;
                        }
                    });
                    jQuery('#programacao-loading').hide();
                    $scope.pageTrack('/programacao/atracao/##'+eventId+'|'+e.name);
                });
                return true;
            }
        });
    });


});

app.controller('espaco', function($scope, $rootScope, $http, $location, $timeout, DataService){

    $scope.space = null;
    $scope.spaceEvents = [];

    var spaceId = parseInt($location.$$hash);

    var c = 0;

    $http.get($scope.conf.templateURL+'/app/events.json?v=' + GlobalConfiguration.md5['events']).success(function(data){
        c++;
        if(c === 2)
            jQuery('#programacao-loading').hide();

        data.forEach(function(e){
            if(e.spaceId == spaceId){
                e.url = eventUrl(e.id);
                $scope.spaceEvents.push(e);
            }
        });
    });

    DataService.getSpaces().then(function(response){
        c++;
        if(c === 2){
            jQuery('#programacao-loading').hide();
        }

        response.data.some(function(e){
            if(e.id == spaceId){
                e.url = spaceUrl(e.id);
                $scope.space = e;
                $scope.mapUrl = getMapUrl(e);
                $scope.pageTrack('/programacao/local/##'+spaceId+'|'+e.name);
                return true;
            }
        });
    });

});


app.controller('programacao', function($scope, $rootScope, $http, $location, $timeout, $window, DataService){
    var page = 0,
        timeouts = {},
        counters = {
            renderList: 0,
            populateEntities: 0
        };

    $scope.conf = GlobalConfiguration;

    $scope.isMobile = hl.isMobile();

    $scope.events = null;
    $scope.spaces = null;
    $scope.spacesByName = null;

    $scope.eventIndex = null;

    $scope.smallDevice = $window.innerWidth < 992;
    $scope.midgetDevice = $window.innerWidth < 768;

    $scope.clearNearMe = function(){
        if($rootScope.filterNearMe.marker)
            $rootScope.filterNearMe.marker.setMap(null);
        if($rootScope.filterNearMe.circle)
            $rootScope.filterNearMe.circle.setMap(null);
    };
    $scope.filterSpaces = function(){
        $scope.filters.spaces=true;
        $scope.pageTrack('/programacao/filter-spaces');
        $scope.clearNearMe();
        //$rootScope.filterNearMe.showMarker
    };

    $rootScope.filterNearMe = {showMarker:false, coords : {}};
    $scope.nearMe = function(){

        $scope.filters.spaces = true;
        $scope.pageTrack('/programacao/filter-near');
        $scope.clearNearMe();

        var getFilterRadius = function (distance){
            if(distance < 500) return 300; else
            if(distance < 1000) return 500; else
            if(distance < 2000) return 1000; else
            if(distance < 3000) return 2000; else
            return 3000;
        };

        var onFound = function (position) {

            var gmap = $rootScope.map.control.getGMap();
            var position = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);

            $rootScope.filterNearMe.coords = position;
            $rootScope.filterNearMe.showMarker = true;

            var nearMeMarker = new google.maps.Marker({
                map: gmap,
                position: position,
                icon: $rootScope.marker.icon.nearMe,
                options : $rootScope.marker.options
            });

            var saoPauloCenter = new google.maps.LatLng(-23.5466623,-46.643183);
            var distanceFromSaoPauloCenter = google.maps.geometry.spherical.computeDistanceBetween(saoPauloCenter,position);
            var filterRadius = getFilterRadius(distanceFromSaoPauloCenter);

            $scope.spaces.forEach(function(s){
                var spacePosition = new google.maps.LatLng(s.location.latitude, s.location.longitude);
                var distance = google.maps.geometry.spherical.computeDistanceBetween(spacePosition,position);
                if(distance < filterRadius)
                    s.selected = true;
            });


            var nearMeInfoWindow = new google.maps.InfoWindow({
                content: '<h5 class="map-space-title">Mostrando somente locais<br> a '+Math.round(filterRadius)+' metros de sua localização aproximada</h5>'
            });

            //nearMeInfoWindow.open(gmap,nearMeMarker);
            google.maps.event.addListener(nearMeMarker, 'click', function() {
                nearMeInfoWindow.open(gmap,nearMeMarker);
            });

            nearMeCircle = new google.maps.Circle({
                map: gmap,
                clickable: false,
                // metres
                radius: filterRadius,
                fillColor: '#fff',
                fillOpacity: .3,
                strokeColor: '#313131',
                strokeOpacity: .4,
                strokeWeight: .8
            });
            nearMeCircle.bindTo('center', nearMeMarker, 'position');

            $rootScope.filterNearMe.marker = nearMeMarker;
            $rootScope.filterNearMe.circle = nearMeCircle;
            $rootScope.filterNearMe.infoWindow = nearMeInfoWindow;

            setTimeout( function () {
                gmap.setCenter(position);
                nearMeInfoWindow.open(gmap,nearMeMarker);
                google.maps.event.trigger(gmap, 'resize');
            },500);

        };


        var onError = function (error) {
            //CATCH ERRORS
           switch (error.code) {
               case error.PERMISSION_DENIED:
                   $scope.geolocationError = "Para buscar locais próximo a você, permita o acesso a sua localização."
                   break;
               case error.POSITION_UNAVAILABLE:
                   $scope.geolocationError = "Sua localização não está disponível."
                   break;
               case error.TIMEOUT:
                   $scope.geolocationError = "O pedido de localização do usuário esgotou o tempo limite."
                   break;
               case error.UNKNOWN_ERROR:
                   $scope.geolocationError = "Um erro desconhecido ocorreu ao encontrar sua localização. Por favor recarregue e tente novamente."
                   break;
           }
           alert($scope.geolocationError);
           //$scope.$apply();
        };
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(onFound, onError);
        }
        else {
            //$scope.error = "Geolocation is not supported by this browser.";
        }
    };

    jQuery(window).resize(function(){
        $scope.smallDevice = $window.innerWidth < 992;
        $scope.midgetDevice = $window.innerWidth < 768;
    });

    $scope.viewByLabels = {
        'space': 'Local',
        'name': 'Atração',
        'time': 'Horário'
    };

    $scope.data = {
        viewBy: 'space',
        viewMode: $scope.smallDevice ? 'list' : 'grid',
        searchText: $location.$$hash
    };

    $rootScope.$on('$locationChangeSuccess', function(){
        if($location.$$hash !== $scope.data.searchText)
            $scope.data.searchText = $location.$$hash;
    });

    $scope.startsAt = '18:00';
    $scope.endsAt = '18:00';

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

    var TIMEOUT_DALAY = 500;

    angular.element($window).bind('resize', function(){
        if($window.innerWidth < 992){
            $scope.data.viewMode = 'list';
            $scope.smallDevice = true;
        }else{
            $scope.smallDevice = false;
        }
        $scope.$apply();
    });
    var startTimeSetted = false;

    $scope.$watch('timeSlider.model.min', function(){
        if(counters.populateEntities === 0 && startTimeSetted)
            return;

        startTimeSetted = true;

        $scope.startsAt = moment('2015-06-20 18:00').add('minutes', $scope.timeSlider.model.min * 15).format('H:mm');

        if(timeouts.timeSlider)
            $timeout.cancel(timeouts.timeSlider);

        startTimeSetted = true;
        if(counters.populateEntities > 0)
            timeouts.timeSlider = $timeout(function(){
                $scope.populateEntities();
                $scope.eventTrack('Filtrando slider de horário inicial', {  category: 'Commands' });
            }, TIMEOUT_DALAY);

    });


    if(!startTimeSetted){
        if(moment() >= moment('2015-06-20 18:00') && moment() < moment('2015-06-21 18:00')){
            var now = moment().subtract('minutes', 15);
            $scope.timeSlider.model.min = parseInt(parseInt(now.diff(moment('2015-06-20 18:00')) / 1000) / 60 / 60 * 4);
        }
    }

    $scope.$watch('timeSlider.model.max', function(){
        if(counters.populateEntities === 0)
            return;
        $scope.endsAt = moment('2015-06-20 18:00').add('minutes', $scope.timeSlider.model.max * 15).format('H:mm');

        if(timeouts.timeSlider)
            $timeout.cancel(timeouts.timeSlider);


        timeouts.timeSlider = $timeout(function(){
            $scope.eventTrack('Filtrando slider de horário final', {  category: 'Commands' });
            $scope.populateEntities();
        }, TIMEOUT_DALAY);
    });

    $scope.$watch('data', function(oldValue, newValue){
        if(counters.populateEntities === 0)
            return;

        if(timeouts.setHash)
            $timeout.cancel(timeouts.setHash);

        timeouts.setHash = $timeout(function(){
            $location.hash($scope.data.searchText);


            if(oldValue.searchText !== newValue.searchText){
                $scope.eventTrack('Filtrando por palavra-chave: "'+$scope.data.searchText+'"', {  category: 'Commands' });
                $scope.eventTrack('"'+$scope.data.searchText+'"', {  category: 'Keyword Search' });
                $scope.populateEntities();
            }else{
                page = 0;
                $scope.renderList();
            }
        }, TIMEOUT_DALAY);
    }, true);

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
        $http.get($scope.conf.templateURL+'/app/spaces-order.json?v=' + GlobalConfiguration.md5['spaces-order']).success(function(order){
            var data = [];
            order.forEach(function(o){

                response.data.slice().forEach(function(s, i){
                    if(s.id == o.id){
                        data.push(s);

                        delete response.data[i];
                    }
                });
            });

            response.data.forEach(function(e){
                data.push(e);
            });

            $scope.spaces = data;
            $scope.spacesById = {};

            $scope.spaceIndex = data.map(function(e,i){
                e.url = spaceUrl(e.id);
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
    });

    $http.get($scope.conf.templateURL+'/app/events.json?v=' + GlobalConfiguration.md5['events']).success(function(data){
        $scope.eventsById = {};

        $scope.events = data;

        $scope.eventIndex = data.map(function(e,i){
            e.url = eventUrl(e.id);
            $scope.eventsById[e.id] = e;

            /*
             * Virada Coral (id:865)
             * 19º Cultural Inglesa Festival (id:)
             * II Mostra de Teatros Independentes (id:)
             * Viradinha 2015 (id:857)
             */

            var projetos = {
                '865': 'Virada Coral',
                '857': 'Viradinha',
                '794': 'II Mostra de Teatros e Espaços Independentes',
                '855': '19º Cultura Inglesa Festival'
            };


            if(e.project && e.project.id && projetos[e.project.id]){
                e.name += ' [' + projetos[e.project.id] + ']';
            }

            return {
                text: $scope.unaccent(e.name + ' ' + e.terms.tag.join(' ') + ' ' + e.terms.linguagem.join(' ') ),
                startsAt : getTime(e.startsAt, e.startsOn),
                entity: e
            };


        });

        $scope.populateEntities();
    });

    function getTime(time, startsOn){
        var t = parseInt(time.replace(':', ''));
        if(t === 1800 && startsOn && startsOn == '2015-06-21'){
            t = 1759;
        }

        if(t < 1800)
            return t + 20000;
        else
            return t + 10000;
    }

    $scope.searchResult = [];
    $scope.searchResultEventsByTime = [];
    $scope.searchResultEventsByName = [];

    $scope.$watch('searchResult', function(o,n){
        $scope.renderList();
    });

    $scope.populateEntities = function(delay){

        if(!$scope.events || !$scope.spaces)
            return;

        delay = delay || 50;

        if(timeouts.populateEntities)
            $timeout.cancel(timeouts.populateEntities);


        timeouts.populateEntities = $timeout(function(){
            var searchResultBySpaceId = {};
            var txt = $scope.unaccent($scope.data.searchText);
            var searchStartsAt = getTime($scope.startsAt);
            var searchEndsAt = $scope.endsAt === '18:00' ? getTime('17:59') : getTime($scope.endsAt);

            var events = [];
            var spaces = [];

            var searchResult = [];

            $scope.eventIndex.forEach(function(event){
                var space = $scope.spacesById[event.entity.spaceId];

                if(event && (txt.trim() === '' || event.text.indexOf(txt) >= 0 || (space && $scope.unaccent(space.name).indexOf(txt) >=0 ) ) && (event.startsAt <= searchEndsAt &&  event.startsAt >= searchStartsAt || event.entity.duration === '24h00')){
                    if(!$scope.filters.spaces || ($scope.spacesById[event.entity.spaceId] && $scope.spacesById[event.entity.spaceId].selected))
                        events.push(event.entity);
                }
            });

            events.forEach(function(event){
                var space = $scope.spacesById[event.spaceId];

                event.spaceName = space ? space.name : '';
                event.spaceUrl = space ? spaceUrl(space.id) : '';

                if(!space) return;

                if(spaces.indexOf(space) < 0)
                    spaces.push(space);
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

            $scope.spaces.forEach(function(s){
                spaces.forEach(function(e){
                    if(s.id == e.id){
                        var space = angular.copy(e);
                        space.isSelected = function(){ return e.selected; };
                        space.events = [];
                        searchResult.push(space);
                        searchResultBySpaceId[space.id] = space;
                    }
                });
            });

            events.forEach(function(event){
                if(searchResultBySpaceId[event.spaceId])
                    searchResultBySpaceId[event.spaceId].events.push(event);
            });

            $scope.searchResult = searchResult;

            RESULTS = {searchResult: $scope.searchResult, searchResultEventsByTime: $scope.searchResultEventsByTime, searchResultEventsByName: $scope.searchResultEventsByName};

            page = 0;

            counters.populateEntities++;


        }, 100);

    };

    var renderingList = false;

    $scope.renderList = function(){
        if(renderingList || counters.populateEntities === 0)
            return;

        timeouts.renderList = $timeout(function(){
            renderingList = true;
            var spacesPerPage = 8;
            var eventsPerPage = 35;
            var offset;

            var $container = jQuery('#main-section');

            var eventTemplate = $scope.data.viewMode === 'list' ? 'template-event-list' : 'template-event-grid';

            if(page === 0)
                $container.html('');

            //$analytics.pageTrack('/programacao/viewMode/'+$scope.data.viewMode);
            //$analytics.pageTrack('/viewBy/'+$scope.data.viewBy+/'viewMode/'+$scope.data.viewMode);

            if($scope.data.viewBy === 'space'){
                offset = page * spacesPerPage;
                $scope.searchResult.slice(offset, offset + spacesPerPage).forEach(function(space){
                    var spaceTemplate = $scope.data.viewMode === 'list' ? 'template-space-list' : 'template-space-grid';
                    var element = appendEntityToContainer(spaceTemplate, space, $container);
                    var $eventsContainer = jQuery(element).find('.js-events-container');

                    appendEntitiesToContainer(eventTemplate, space.events, $eventsContainer);

                    if($scope.data.viewMode === 'grid'){
                        if(hl.isMobile()){
                            hl.scrollCarrousel.init($eventsContainer.parents('.hl-carrousel'));
                        }else{
                            hl.carrousel.init($eventsContainer.parents('.hl-carrousel'));
                        }
                    }
                });
            }else{
                offset = page * eventsPerPage;

                var events = $scope.data.viewBy === 'time' ? $scope.searchResultEventsByTime : $scope.searchResultEventsByName;

                appendEntitiesToContainer(eventTemplate, events.slice(offset, offset + eventsPerPage), $container);
            }

            jQuery('#programacao-loading').hide();

            minhaVirada.atualizaEstrelas();
            if(minhaVirada.uid){
                minhaVirada.atualizaAmigos();
            }


            var grid_width,
                grid_height;

            function appendEntitiesToContainer(template, entities, $container){
                entities.forEach(function(entity){
                    var $element = jQuery(Resig.renderElement(template, entity));

                    $container.append($element);

                    if($scope.data.viewMode === 'grid'){
                        grid_width = grid_width || parseInt(jQuery('#main-section').outerWidth(true) * .2);
                        grid_height = grid_height || parseInt(grid_width * .66667);

                        jQuery('article.event').css({ height: grid_height + 34 });
                    }
                });
            }

            function appendEntityToContainer(template, entity, $container){
                var $element = jQuery(Resig.render(template, entity));
                $container.append($element);
                return $element;
            }

            page++;

            renderingList = false;

            counters.renderList++;


            var virtualPath = '/programacao/'+$scope.data.viewMode+'-mode/by-'+$scope.data.viewBy;

            virtualPath += '/page-'+page;

            if($scope.data.searchText) virtualPath += '/text|'+$scope.data.searchText;
            if($scope.startsAt != '18:00') virtualPath += '/starts|'+$scope.startsAt;
            if($scope.endsAt != '18:00') virtualPath += '/ends|'+$scope.endsAt;

            $scope.pageTrack(virtualPath);


        });
    };

    jQuery(window).scroll(function(){
        if(jQuery(window).height() + jQuery(this).scrollTop() >= jQuery('body').height() - jQuery(window).height() / 2)
            $scope.renderList();
    });
    jQuery(window).scroll();

});

app.controller('minha-virada', function($rootScope, $scope, $http, $location, $timeout, DataService){

    $scope.hasEvents = false;
    $scope.userEvents = [];
    $scope.user_name = 'Minha Virada';
    $scope.connected = false;
    $scope.home = true; // não estou vendo perfil de ninguém
    $scope.itsme = false;
    $scope.user_picture = '';

    $rootScope.$on("$locationChangeSuccess", function () {
        $scope.loadUserData($location.$$hash);
    });

    $rootScope.$on('ngRepeatFinished', function(e){
        if($scope.connected){
            minhaVirada.atualizaEstrelas();
            minhaVirada.atualizaAmigos();
        }
    });

    $rootScope.$on('fb_connected', function(ev, uid) {
        $scope.connected = true;

        $scope.home = false;


        if ($location.$$hash) {
            if ($location.$$hash == uid) {

                $scope.itsme = true;
                minhaVirada.inMyPage = true;
                $scope.$apply();
            }
            return;
        }

        $scope.itsme = true;
        minhaVirada.inMyPage = true;

        $scope.$apply();

        $scope.loadUserData(uid);
        $location.hash(uid);
        $scope.$emit('minhavirada_hashchanged', document.URL + '##' + $location.$$hash);

        $scope.pageTrack('/minha-virada/' + $location.$$hash);

    });

    $rootScope.$on('fb_not_connected', function(ev, uid) {

        jQuery('#programacao-loading').hide();
        if (!$location.$$hash)
            jQuery('.user-photo').hide();

        $scope.pageTrack('/minha-virada/');

    });

    $scope.loadUserData = function(uid) {
        $http.get(minhaVirada.api.getUrl('minhavirada') + '?uid='+uid).success(function(data){
            $scope.populateUserInfo(data);
        });
    };

    $scope.populateUserInfo = function(data) {


        if ( typeof(data.picture) != 'undefined' ) {

            $scope.user_picture = "background-image: url(" + data.picture + ");";
            $scope.user_name = data.name;

        } else {
            jQuery('.user-photo').hide();
        }

        $http.get($scope.conf.templateURL+'/app/events.json?v=' + GlobalConfiguration.md5['events']).success(function(allEvents){
            $scope.userEvents = [];
            allEvents.forEach(function(e){
                if (data.events && data.events.length > 0) {
                    $scope.hasEvents = true
                    for (var i = 0; i < data.events.length; i++) {
                        if(e.id == data.events[i]) {
                            $scope.userEvents.push(e);
                            e.url = eventUrl(e.id);
                            break;
                        }
                    }
                }

            });

            jQuery('#programacao-loading').hide();
            minhaVirada.atualizaEstrelas();

            $rootScope.$emit('minhavirada_userInfoPopulated');

        });

    }

    if ($location.$$hash) {
        $scope.home = false;
        $scope.pageTrack('/minha-virada/' + $location.$$hash);
        $scope.loadUserData($location.$$hash);
    }



});
