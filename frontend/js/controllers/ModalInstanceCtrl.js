cabinetControllers.controller('ModalInstanceCtrl', [
    "$scope", "$uibModalInstance",
    "ClockSvc", "$uibModal",
    "AuthenticationSvc", "$rootScope", "$window", "$timeout",
    function ($scope, $uibModalInstance, ClockSvc, $uibModal, AuthenticationSvc, $rootScope, $window, $timeout) {
        $scope.flag = false;
        $timeout(function () {
            if (!$scope.flag) {
                ClockSvc.clockLogout();
            }
        }, 15000); //15 seconds 

        $scope.ok = function () {
            ClockSvc.clockLogout();
        };

        $scope.cancel = function () {
            $rootScope.clock = null;
            clearInterval(int);
            
            $scope.flag = true;
            $uibModalInstance.dismiss();
            var cancelFlag = true
            if ($rootScope.isLogedIn) {
                cancelFlag = false;
            }
            ClockSvc.injectClockWithoutLogIn($uibModal, cancelFlag, true);
        };

    }]);

