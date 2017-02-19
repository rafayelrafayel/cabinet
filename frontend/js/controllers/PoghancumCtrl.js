cabinetControllers.controller('PoghancumCtrl', ["$scope", "$location", "$window", "AccountManagementSvc", "StorageSvc", function ($scope, $location, $window, AccountManagementSvc, StorageSvc) {


        //console.log($window.sessionStorage);
        $scope.form = {
            recipientPhoneNumber: '',
            amount: ''


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
                
            }), function () {
            };
            
        }
        getNewDayParam();
       //  console.log($scope.info);
         //console.log($scope.currentInfo);
       

        $scope.transfer = function () {

            AccountManagementSvc.tranferMoney($scope.form).then(function () {
                $location.path("/accountManagement");
            }), function () {
               
            };

        };
        
        $scope.isDisabled = function (amount, boolean) {
           
           
            return   !($scope.info.MinBalanceRemainder < ( $scope.currentInfo.Balance - (amount))) || boolean
           
        };

    }]);

