cabinetControllers.controller('HeaderUserInfoCtrl', [
    "$scope", "$window", "StorageSvc", "AuthenticationSvc", "$location", "$filter",
    function ($scope, $window, StorageSvc, AuthenticationSvc, $location, $filter) {

        $scope.headerInfo = {
            phoneNumber: '',
            Balance: '',
            LyfeCycleStatus: '',
            TariffPlanDescription: '',
            ExpiryDate: ''
        };

        $scope.lngCode = getCurrentLangCode();

        if (StorageSvc.isNotEmpty()) {
            var status = StorageSvc.getProperty('LyfeCycleStatus', 'userData'),
                   // date_exp = new Date(StorageSvc.getProperty('ExpiryDate', 'userData')),
                    date_exp = StorageSvc.getProperty('ExpiryDate', 'userData'),
                    statusStr;
            $scope.isPrepaid = StorageSvc.getProperty('IsPrepaid', 'userData');

            if ($scope.isPrepaid) {
                if (status === 1) {
                    statusStr = $filter('translate')('suspended');
                }
                if (status === 2) {
                    statusStr = $filter('translate')('active');
                }

                if (status === 3) {
                    statusStr = $filter('translate')('grace_period');
                }
                if (status === 4) {
                    statusStr = $filter('translate')('expired');
                }
            } else {
                if (status === 1) {
                    statusStr = $filter('translate')('active');
                }
                if (status === 2) {
                    statusStr = $filter('translate')('warn');
                }
                if (status === 5 || status === 4 || status === 3) {
                    statusStr = $filter('translate')('suspended');
                }
                if (status === 6) {
                    statusStr = $filter('translate')('terminated');
                }

               //date_exp = new Date(StorageSvc.getProperty('SubscriberLastBillDate', 'userData'));
                date_exp = StorageSvc.getProperty('SubscriberLastBillDate', 'userData');
            }

               console.log(StorageSvc.getProperty('SubscriberLastBillDate', 'userData')) ;
               console.log(date_exp);

            $scope.headerInfo = {
                phoneNumber: StorageSvc.getProperty('phoneNumber', 'userData'),
                Balance: StorageSvc.getProperty('Balance', 'userData'),
                TariffPlanDescription: StorageSvc.getTariffPlanInfo('TariffPlanName' + $scope.lngCode.capitalize()),
                LyfeCycleStatus: statusStr,
                ExpiryDate: date_exp
            };

            // console.log($scope.headerInfo);
        }



    }]);

