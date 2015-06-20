minhaVirada = {
    baseApiUrl: 'http://viradacultural.prefeitura.sp.gov.br/2015/api/',
//    baseApiUrl: 'http://192.168.0.70:8000/',

    uid: false,
    accessToken: false,
    eventId: false,
    connected: false,
    username: false,
    name: false,
    picture: false,
    events: [],
    modalDismissed: false,
    data: false,
    initialized: false,
    inMyPage: false,

    api: {
        getUrl: function(action){
            return minhaVirada.baseApiUrl + action + '/';
        }
    },

    connect: function(callback) {
        var callback = 'minhaVirada.' + callback + '()';

        if (minhaVirada.connected) {
            eval(callback);
            return;
        }


        FB.getLoginStatus(function(response) {

            if (response.status === 'connected') {
                // the user is logged in and has authenticated your
                // app, and response.authResponse supplies
                // the user's ID, a valid access token, a signed
                // request, and the time the access token
                // and signed request each expire

                minhaVirada.initializeUserData(response, callback);
            } else {

                // the user isn't logged in to Facebook.
                FB.login(function(response){
                    if (response.authResponse) {
                        // The person logged into your app
                        minhaVirada.initializeUserData(response, callback);
                    } else {
                        // The person cancelled the login dialog
                    }
                });

            }
        });
    },

    initializeUserData: function(response, callback) {
        minhaVirada.connected = true;
        minhaVirada.uid = response.authResponse.userID;
        minhaVirada.accessToken = response.authResponse.accessToken;

        setTimeout(function(){
            minhaVirada.atualizaAmigos();
        });

        FB.api('/me', {fields: ['name', 'picture.height(200)']}, function(response) {

            minhaVirada.name = response.name;
            minhaVirada.picture = response.picture.data.url;

            // Pega dados do usuário
            jQuery.getJSON( minhaVirada.api.getUrl('minhavirada') + '?uid=' + minhaVirada.uid, function( data ) {
                var cb = function(){
                    minhaVirada.debug = data;

                    if (!data.events){
                        minhaVirada.events = [];
                    }else{
                        minhaVirada.events = data.events;
                    }


                    minhaVirada.modalDismissed = true;


                    minhaVirada.initialized = true;
                    minhaVirada.atualizaEstrelas();

                    if (callback){
                        eval(callback);
                    }

                    jQuery('#modal-facebook-disclaimer').modal('hide');
                };

                if(!data){
                    jQuery('#modal-facebook-disclaimer').modal('show');
                    jQuery('#modal-facebook-disclaimer .js-accept').click(function(){
                        cb();
                    });

                    jQuery('#modal-facebook-disclaimer .js-cancel').click(function(){
                        FB.api("/me/permissions","DELETE",function(response){
                        });
                        jQuery('#modal-facebook-disclaimer').modal('hide');
                    });
                }else{
                    cb();
                }

            });



        });

        // Dismiss modal
        jQuery('#modal-favorita-dismiss').click(function() {

            minhaVirada.modalDismissed = true;
            jQuery('#modal-favorita-evento').modal('hide');
            minhaVirada.save();
        });

    },

    prepareJSON: function() {
        var json = {
            uid: minhaVirada.uid,
            picture: minhaVirada.picture,
            events: minhaVirada.events,
            name: minhaVirada.name,
            modalDismissed: minhaVirada.modalDismissed
        }
        return json;
    },

    save: function() {
        var userJSON = minhaVirada.prepareJSON();


        jQuery.ajax(minhaVirada.api.getUrl('minhavirada'), {
            method: 'POST',
            data: JSON.stringify(userJSON),
            contentType: 'application/json',
            success: function( data ) {
                // atualiza estrelas
                minhaVirada.atualizaEstrelas();
                if (!minhaVirada.modalDismissed)
                    jQuery('#modal-favorita-evento').modal('show');
            }
        });
//
//        jQuery.post( minhaVirada.api.getUrl('minhavirada'), JSON.stringify(userJSON), function( data ) {
//            // atualiza estrelas
//            minhaVirada.atualizaEstrelas();
//            if (!minhaVirada.modalDismissed)
//                jQuery('#modal-favorita-evento').modal('show');
//        }, 'json');
    },

    atualizaEstrelas: function() {
        if(minhaVirada.initialized) {
            jQuery('.favorite').removeClass('favorite-wait');
        }

        if (!minhaVirada.connected)
            return;
        jQuery('.favorite').removeClass('active');
        for (var i = 0; i < minhaVirada.events.length; i++) {
            jQuery('.favorite-event-'+minhaVirada.events[i]).addClass('active');
        }

    },

    eventosAmigos: null,

    _atualizaAmigos: function(){
        var templateName, $lista;
        $lista = jQuery('.js-lista-amigos');
        if($lista.hasClass('js-lista-atracao')){
            templateName = 'template-lista-de-amigos-single-atracao';
            var eventId = $lista.data('eventId');

            if(minhaVirada.eventosAmigos[eventId]){
                $lista.html(Resig.render(templateName, {eventId: eventId, eventUrl: eventUrl(eventId) ,friends: minhaVirada.eventosAmigos[eventId]}));

                $lista.find('[data-toggle="tooltip"]').tooltip();
            }
        }else{
            templateName = 'template-lista-de-amigos';
            Object.keys(minhaVirada.eventosAmigos).forEach(function(eventId){
                $lista = jQuery('.js-event-' + eventId + ' .js-lista-amigos');

                $lista.html(Resig.render(templateName, {eventId: eventId, eventUrl: eventUrl(eventId) ,friends: minhaVirada.eventosAmigos[eventId]}));

                $lista.find('[data-toggle="tooltip"]').tooltip();
            });
        }
    },

    atualizaAmigos: function() {
        if(!this.eventosAmigos){
            jQuery.getJSON(minhaVirada.api.getUrl('friendsevents'), {oauth_token: minhaVirada.accessToken, fbuser_uid: minhaVirada.uid}, function(rs){
                minhaVirada.eventosAmigos = rs;
                minhaVirada._atualizaAmigos();
            });
        }else{
            minhaVirada._atualizaAmigos();
        }
    },

    // retorna falso se não tem, ou o índice se tem
    has_event: function(eventId) {

        if (!minhaVirada.connected)
            return false;

        for (var i = 0; i < minhaVirada.events.length; i++) {

            if (minhaVirada.events[i] == eventId)
                return i;
        }
        return false;
    },

    click: function(eventId) {
        minhaVirada.eventId = eventId;
        minhaVirada.connect('doClick');
    },

    doClick: function() {
        if (minhaVirada.eventId) {
            var has_event = minhaVirada.has_event(minhaVirada.eventId);
            if (has_event !== false ) { // o indice pode ser 0

                //if (confirm('Tem certeza que quer remover esta atração da sua seleção?')) {

                    minhaVirada.events.splice(has_event, 1);

                    // Se estiver editando a pagina minha virada, exclui o evento da página
                    if (minhaVirada.inMyPage)
                        jQuery('#event-group-' + minhaVirada.eventId).fadeOut(function() {
                            jQuery(this).remove();
                        });
                //}

            } else {
                minhaVirada.events.push(minhaVirada.eventId);
            }
            minhaVirada.save();
        }
    }
}
