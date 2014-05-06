minhaVirada = {

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

        FB.api('/me', {fields: ['name', 'username', 'picture.height(200)']}, function(response) {
            //console.log(response);
            minhaVirada.userame = response.username;
            minhaVirada.name = response.name;
            minhaVirada.picture = response.picture.data.url;

            // Pega dados do usuário
            jQuery.getJSON( GlobalConfiguration.templateURL + '/includes/minha-virada-ajax.php?action=minhavirada_getJSON&uid=' + minhaVirada.uid, function( data ) {

                minhaVirada.debug = data;

                if (!data.events)
                    minhaVirada.events = [];
                else
                    minhaVirada.events = data.events;

                if (data.modalDismissed)
                    minhaVirada.modalDismissed = data.modalDismissed;
                    
                minhaVirada.initialized = true;
                minhaVirada.atualizaEstrelas();
                
                if (callback)
                    eval(callback);

                
            });



        });

        // Dismiss modal
        jQuery('#modal-favorita-dismiss').click(function() {
            console.log('dismissed');
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
        jQuery.post( GlobalConfiguration.templateURL + '/includes/minha-virada-ajax.php', {action: 'minhavirada_updateJSON', dados: userJSON }, function( data ) {
            // atualiza estrelas
            minhaVirada.atualizaEstrelas();
            if (!minhaVirada.modalDismissed)
                jQuery('#modal-favorita-evento').modal('show');
        });
    },

    atualizaEstrelas: function() {
        if(minhaVirada.initialized) {
            jQuery('.favorite').show();
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
                    if (jQuery('div.js-page-minha-virada').size() > 0)
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
