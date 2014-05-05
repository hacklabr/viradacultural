
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

var eventUrl = function(eventId){
    return GlobalConfiguration.baseURL + '/programacao/atracao/##' + eventId;
};

var spaceUrl = function(spaceId){
    return GlobalConfiguration.baseURL + '/programacao/local/##' + spaceId;
};

var getMapUrl = function (spaceEntity){
    var e = spaceEntity;
    return "https://maps.google.com/maps?hl=pt-BR&geocode=&q=" + e.name + ", " + e.endereco + ", São Paulo - SP, Brasil&sll=" + e.location.latitude + "," + e.location.longitude + "&ie=UTF8&hq=" + e.name + ", " + e.endereco + ", São Paulo - SP, Brasil&hnear=&radius=15000&t=m&ll=" + e.location.latitude + "," + e.location.longitude + "&z=17&output=embed&iwloc=near&language=pt-BR&region=br";
};

var app = angular.module('virada', ['google-maps','ui-rangeSlider']);

(function getThemeDir(){
    var scripts = document.getElementsByTagName('script');
    if(scripts.length === 0) return;

    var index = scripts.length - 1;
    var viradajs = scripts[index];

    if(viradajs) {
        var themeDir = viradajs.src.replace(/app\/virada\.js$/, '');
        app.constant('THEME_DIR', themeDir);
    }
})();

app.directive('onLastRepeat', function() {
    return function(scope, element, attrs) {
        if (scope.$last) setTimeout(function(){
            scope.$emit('onRepeatLast', element, attrs);
        }, 1);
    };
});


app.controller('main', function($scope, $rootScope, $window, $sce){
    $scope.conf = GlobalConfiguration;

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
            }else{
                minhaVirada.initialized = true;
                minhaVirada.atualizaEstrelas();
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
                e.url = eventUrl(e.id);
                DataService.getSpaces().then(function(response){
                    response.data.some(function(e){
                        if(e.id == $scope.event.spaceId){
                            e.url = spaceUrl(e.id);
                            $scope.space = e;
                            $scope.mapUrl = getMapUrl(e);

                            jQuery('#programacao-loading').hide();
                            return true;
                        }
                    });
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

    $http.get($scope.conf.templateURL+'/app/events.json').success(function(data){
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
        if(c === 2)
            jQuery('#programacao-loading').hide();

        response.data.some(function(e){
            if(e.id == spaceId){
                e.url = spaceUrl(e.id);
                $scope.space = e;
                $scope.mapUrl = getMapUrl(e);
                return true;
            }
        });
    });

});


app.controller('programacao', function($scope, $rootScope, $http, $location, $timeout, $window, DataService){
    var page = 0,
        timeouts = {};

    $scope.conf = GlobalConfiguration;

    $scope.events = null;
    $scope.spaces = null;
    $scope.spacesByName = null;

    $scope.eventIndex = null;

    $scope.smallDevice = $window.innerWidth < 992;
    $scope.midgetDevice = $window.innerWidth < 768;

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

    angular.element($window).bind('resize', function(){
        if($window.innerWidth < 992){
            $scope.data.viewMode = 'list';
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

    $scope.$watch('data', function(oldValue, newValue){
        if(timeouts.setHash)
            $timeout.cancel(timeouts.setHash);

        $timeout(function(){
            $location.hash($scope.data.searchText);
        },750);

        if(oldValue.searchText !== newValue.searchText){
            $scope.populateEntities();
        }else{
            page = 0;
            $scope.renderList();
        }
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
        $http.get($scope.conf.templateURL+'/app/spaces-order.json').success(function(order){
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

    $http.get($scope.conf.templateURL+'/app/events.json').success(function(data){
        $scope.eventsById = {};

        $scope.events = data;

        $scope.eventIndex = data.map(function(e,i){
            e.url = eventUrl(e.id);
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

    $scope.$watch('searchResult', function(){
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
                if(event && (txt.trim() === '' || event.text.indexOf(txt) >= 0) && (event.startsAt <= searchEndsAt  &&  event.startsAt >= searchStartsAt || event.entity.duration === '24h00')){
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
        }, 100);

    };

    var renderingList = false;
    $scope.renderList = function(){
        if(renderingList || (!$scope.spaces || !$scope.events))
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

            if($scope.data.viewBy === 'space'){
                offset = page * spacesPerPage;
                $scope.searchResult.slice(offset, offset + spacesPerPage).forEach(function(space){
                    var spaceTemplate = $scope.data.viewMode === 'list' ? 'template-space-list' : 'template-space-grid';
                    var element = appendEntityToContainer(spaceTemplate, space, $container);
                    var $eventsContainer = jQuery(element).find('.js-events-container');

                    appendEntitiesToContainer(eventTemplate, space.events, $eventsContainer);

                    if($scope.data.viewMode === 'grid'){
                        hl.carrousel.init($eventsContainer.parents('.hl-carrousel'));
                    }
                });
            }else{
                offset = page * eventsPerPage;

                var events = $scope.data.viewBy === 'time' ? $scope.searchResultEventsByTime : $scope.searchResultEventsByName;

                appendEntitiesToContainer(eventTemplate, events.slice(offset, offset + eventsPerPage), $container);
            }

            jQuery('#programacao-loading').hide();

            minhaVirada.atualizaEstrelas();

            function fadeInImages($element, delay){
                $element.find('img').each(function(){
                    var $this = jQuery(this);
                    if(this.complete){
                        $this.hide();
                        setTimeout(function(){ $this.fadeIn('fast'); }, delay);
                        delay = delay + 10;
                    }else{
                        $this.hide().load(function(){
                            $this.fadeIn('fast');
                        });
                    }
                });
            }

            var grid_width,
                grid_height;

            function appendEntitiesToContainer(template, entities, $container){
                var delay = 0;
                entities.forEach(function(entity){
                    var $element = jQuery(Resig.renderElement(template, entity));

                    $container.append($element);

                    if($scope.data.viewMode === 'grid'){
                        grid_width = grid_width || parseInt(jQuery('#main-section').outerWidth(true) * .2);
                        grid_height = grid_height || parseInt(grid_width * .66667);

                        fadeInImages($element, delay);
                        delay += 10;

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
        $http.get($scope.conf.templateURL + '/includes/minha-virada-ajax.php?action=minhavirada_getJSON&uid='+uid).success(function(data){
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
