
var ErrorModule = angular.module('ErrorModule', []);
ErrorModule.factory("ErrorSvc", ["$location", "AuthenticationSvc", "$filter", "$window", function ($location, AuthenticationSvc, $filter, $window) {

//logout()
        function handleErrors(result) {
            //console.log(result);
            if (result.data.error_code === 1007) {
                AuthenticationSvc.logout().then(function () {
                    $window.location.href = 'http://localhost:8002/index';
                }), function () {
                    $window.location.href = 'http://localhost:8002/index';
                };
            } else {
                var mess = $filter('translate')('error_'+result.data.error_code);
                popupOpen(mess);
            }
        }

        return {
            handleErrors: handleErrors
        };
    }]);


