cabinetControllers.controller('NewdayCtrl', [
    "$scope", "$location", "$window", "AccountManagementSvc", "StorageSvc", "$timeout",
    function ($scope, $location, $window, AccountManagementSvc, StorageSvc, $timeout) {


        //console.log($window.sessionStorage);
        $scope.newday = {
            day: ''
        };

        $scope.info = {
            DayCost: '',
            MaxDayCountForAdd: '',
            MinBalanceRemainder: ''
        };




        $scope.parseInt = function (value)
        {
            if (isNaN(parseInt(value)))
                return  0;
            return parseInt(value);
        }




        $scope.currentInfo = {
            Balance: StorageSvc.getProperty('Balance', 'userData'),
            ExpiryDateDays: date2days(undefined, new Date(StorageSvc.getProperty('ExpiryDate', 'userData')))
        };


        function getNewDayParam() {
            AccountManagementSvc.getNewDayParam().then(function (data) {
                $scope.info = {
                    DayCost: data.DayCost,
                    MaxDayCountForAdd: data.MaxDayCountForAdd,
                    MinBalanceRemainder: data.MinBalanceRemainder
                };
                console.log($scope.info);
            }), function () {
            };
        }
        getNewDayParam();


        $scope.convert = function () {
            $scope.amount = {
                amount: parseInt($scope.newday.day) * $scope.info.DayCost
            };
            AccountManagementSvc.addNewDay($scope.amount).then(function () {
                $location.path("/accountManagement");
            }), function () {

            };

        };


        $scope.isDisabled = function (boolean) {
              return  !(((parseInt($scope.newday.day) +  $scope.currentInfo.ExpiryDateDays) <=  $scope.info.MaxDayCountForAdd) && ( $scope.info.MinBalanceRemainder < ( $scope.currentInfo.Balance - (parseInt($scope.newday.day) *  $scope.info.DayCost)))) || boolean;

         

        };

    }]);

