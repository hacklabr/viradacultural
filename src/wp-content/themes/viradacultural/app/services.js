(function(){

    var app = angular.module('virada');

    app.service('Query',[ '$http',
        function QuerySrv($http) {
            var Query = {};

            Query.do = function() {
                // TODO: terminar de implmentar quando houver um webservice
                return $http.get('/wp-content/themes/viradacultural/app/spaces.json');
            };

            return Query;
        }
    ]);

})(window.angular);