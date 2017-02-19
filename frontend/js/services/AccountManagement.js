
var AccountManagement = angular.module('AccountManagementModule', []);
AccountManagement.factory("AccountManagementSvc", ["$q", "$http", "apiUrl", "StorageSvc", "ErrorSvc", "SuccessMvc", function ($q, $http, apiUrl, StorageSvc, ErrorSvc, SuccessMvc) {

        function addNewDay(requestData) {
            return call(apiUrl.addNewDay, requestData);

        }

        function tranferMoney(requestData) {
            return call(apiUrl.tranferMoney, requestData);

        }

        function getNewDayParam() {
            return call(apiUrl.getNewDayParam);
        }

        function sendMessage(requestData) {
            return call(apiUrl.sendMessageDetailedBill,requestData);
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
                    SuccessMvc.handleMessage(result, url);
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
            addNewDay: addNewDay,
            tranferMoney: tranferMoney,
            sendMessage: sendMessage,
            getNewDayParam: getNewDayParam
        };
    }]);


