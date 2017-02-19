cabinetControllers.controller('HeaderCtrl', ["$scope", "$window", "StorageSvc", "AuthenticationSvc", "$location", "$rootScope", function ($scope, $window, StorageSvc, AuthenticationSvc, $location, $rootScope) {


        $scope.logOut = function () {
            var homePage = 'http://localhost:8002/index';
            if ($rootScope.isLogedIn) {
                AuthenticationSvc.logout().then(function () {
                    $window.location.href = homePage
                }), function () {
                    $window.location.href = homePage
                };

            } else {
                $window.location.href = homePage;
            }

        };



    }]);

