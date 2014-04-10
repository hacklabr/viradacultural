(function(){

    var app = angular.module('virada');

    app.service('DataService',[ '$http',
        function DataService($http) {
            var DataService = {};

            DataService.search = function() {
                // TODO: terminar de implmentar quando houver um webservice
                return $http.get('/wp-content/themes/viradacultural/app/spaces.json');
            };

            return DataService;
        }
    ]);

})(window.angular);