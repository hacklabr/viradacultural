(function(){

    var app = angular.module('virada');
    var conf = GlobalConfiguration;

    app.service('DataService',['$http',
        function DataService($http) {
            var DataService = {};

            var spacesDefer = $http.get(conf.templateURL+'/app/spaces.json');
            DataService.getSpaces = function() {
                return spacesDefer;
            };

            return DataService;
        }
    ]);

})(window.angular);