cabinetControllers.controller('BonusCtrl', ["$scope", "$location", "$window", "AccountManagementSvc", "StorageSvc", function ($scope, $location, $window, AccountManagementSvc, StorageSvc) {


        //console.log($window.sessionStorage);
       
       

        

        $scope.convert = function () {
            $scope.amount = {
                amount: parseInt($scope.newday.day) * 20
            };
            AccountManagementSvc.addNewDay($scope.amount).then(function () {
                $location.path("/accountManagement");
            }), function () {
               
            };

        };

    }]);

