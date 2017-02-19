
var Bonus = angular.module('BonusModule', []);
Bonus.factory("BonusSvc", ["$q", "$http", "apiUrl", "StorageSvc", "ErrorSvc", "SuccessMvc", function ($q, $http, apiUrl, StorageSvc, ErrorSvc, SuccessMvc) {

        function getMtsBonusPoints(){
            return call(apiUrl.getMtsBonusPoints);
        }
        
        function getMtsBonusList(){
            return call(apiUrl.getMtsBonusList);
        }
        
        function convertMtsBonusPoints(requestData){
            return call(apiUrl.convertMtsBonusPoints,requestData);
        }
        
        function getMTSBonusHistory(requestData){
             return call(apiUrl.getMTSBonusHistory,requestData);
        }

        function call(url, data) {
            var deferred = $q.defer(), data = data || {};

            $http({
                method: "POST",
                url: url,
                data: data,
                headers: {
                    "Access-Token": StorageSvc.getProperty('accessToken')
                },
                beforeSend: function () {
                    callLoading(true);
                },
                complete: function () {
                    callLoading(false);
                }
            }).then(function (result) {
                if (result.data.error_code === 0 || result.data.error_code === 1) {
                    SuccessMvc.handleMessage(result,url);
                    deferred.resolve(result.data);
                } else {
                    ErrorSvc.handleErrors(result);
                }
            }, function (error) {
                deferred.reject(error);
            });
            return deferred.promise;
        }




        return {
            getMtsBonusPoints: getMtsBonusPoints,
            getMtsBonusList: getMtsBonusList,
            convertMtsBonusPoints:convertMtsBonusPoints,
            getMTSBonusHistory:getMTSBonusHistory
           
        };
    }]);


