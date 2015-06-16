minhaVirada = {
    baseUrl: 'http://viradacultural.prefeitura.sp.gov.br/2015/api/minhavirada/',
//    baseUrl: 'http://192.168.0.61:8000/minhavirada/',

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

        FB.api('/me', {fields: ['name', 'picture.height(200)']}, function(response) {
            //console.log(response);
            //minhaVirada.userame = response.username;
            minhaVirada.name = response.name;
            minhaVirada.picture = response.picture.data.url;

            // Pega dados do usuário
            jQuery.getJSON( minhaVirada.baseUrl + '?uid=' + minhaVirada.uid, function( data ) {
                var cb = function(){
                    minhaVirada.debug = data;

                    if (!data.events){
                        minhaVirada.events = [];
                    }else{
                        minhaVirada.events = data.events;
                    }

                    if (data.modalDismissed){
                        minhaVirada.modalDismissed = data.modalDismissed;
                    }

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
                            console.log(response); //gives true on app delete success
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
            //console.log('dismissed');
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


        jQuery.ajax(minhaVirada.baseUrl, {
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
//        jQuery.post( minhaVirada.baseUrl, JSON.stringify(userJSON), function( data ) {
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
        //console.log(minhaVirada.events);
        //console.log(minhaVirada.eventId);
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
