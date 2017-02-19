
    var Storage = angular.module('StorageServicesModule', []);
    Storage.factory("StorageSvc", ["$window",function ($window) {   

        function isNotEmpty() {
            if($window.sessionStorage.hasOwnProperty('userInfo') && $window.sessionStorage['userInfo'] !== 'null'){
                return  true;
            } 
            return false;
           
        }
        function getStorage() {

            if ($window.sessionStorage.hasOwnProperty('userInfo') && $window.sessionStorage['userInfo'] !== 'null') {
                return  JSON.parse($window.sessionStorage['userInfo']);
            }
            return {};
        }

        function getProperty(name, from) {
            var name = name || null,
                    from = from || null;
            var stoarageInfo = getStorage();

            if (typeof stoarageInfo === 'object') {
                if (name !== null) {
                    if (from === null) {
                        return stoarageInfo[name];
                    } else if (stoarageInfo.hasOwnProperty(from)) {
                        return stoarageInfo[from][name];
                    }
                }
            }
            return null;
        }

        function getTariffPlanInfo(name) {
            var name = name || null,
                    stoarageInfo = getStorage();
            if (!(typeof stoarageInfo === 'object' && stoarageInfo.hasOwnProperty('userData'))) {
                return null;
            }
            if (null === name) {
                return stoarageInfo['userData']['TariffPlanInfo'];
            } else {
                return stoarageInfo['userData']['TariffPlanInfo'][name];
            }
            return null;
        }

        return {
            isNotEmpty: isNotEmpty,
            getProperty: getProperty,
            getStorage:getStorage,
            getTariffPlanInfo: getTariffPlanInfo
        };
    }]);


