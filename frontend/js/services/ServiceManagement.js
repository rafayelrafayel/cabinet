    var ServiceManagement = angular.module('ServiceManagementModule', []);
    ServiceManagement.factory("ServiceManagementSvc",["$q","$http","StorageSvc","apiUrl","ErrorSvc","SuccessMvc", function ($q, $http, StorageSvc, apiUrl, ErrorSvc, SuccessMvc) {

        function addToBlockList(requestData) {
            return call(apiUrl.addToBlockList, requestData);

        }
        function addToWhiteList(requestData) {
            return call(apiUrl.addToWhiteList, requestData);

        }

        function isBlockedForAll() {
            return call(apiUrl.isBlockedForAll);
        }


        function addToFavoriteList(requestData) {
            return call(apiUrl.addToFavoriteList, requestData);

        }

        function getNumberList(requestData) {
            return call(apiUrl.getNumbersList, requestData);

        }

        function unBlockFromList(requestData) {

            return call(apiUrl.unBlockFromList, requestData);

        }


        function changeNumberFromList(requestData) {
            return call(apiUrl.replaceNumberInList, requestData);

        }


        function blockAll() {
            return call(apiUrl.blockAll);
        }

        function unBlockAll() {
            return call(apiUrl.unBlockAll);
        }


        function forward(requestData) {
            return call(apiUrl.forward, requestData);
        }

        function cancelForward(requestData) {
            return call(apiUrl.cancelForward, requestData);
        }


        function getCallForwardInfo() {
            return call(apiUrl.getCallForwardInfo);
        }


        function call(url, data) {
            var deferred = $q.defer(), data = data || {};

            $http({
                method: "POST",
                url: url,
                data: data,
                headers: {
                    "Access-Token": StorageSvc.getProperty('accessToken')
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
            addToBlockList: addToBlockList,
            addToFavoriteList: addToFavoriteList,
            addToWhiteList: addToWhiteList,
            getNumberList: getNumberList,
            unBlockFromList: unBlockFromList,
            blockAll: blockAll,
            unBlockAll: unBlockAll,
            forward: forward,
            cancelForward: cancelForward,
            getCallForwardInfo: getCallForwardInfo,
            changeNumberFromList: changeNumberFromList,
            isBlockedForAll: isBlockedForAll
        };
    }]);


