
var Authentication = angular.module('AuthenticationServicesModule', []);
Authentication.factory("AuthenticationSvc", ["$http", "$q", "$location", "$rootScope", "$window", "apiUrl", "StorageSvc", "$filter", function ($http, $q, $location, $rootScope, $window, apiUrl, StorageSvc, $filter) {
        var userInfo;
        function init() {
            if ($window.sessionStorage["userInfo"]) {
                userInfo = JSON.parse($window.sessionStorage["userInfo"]);
            }
        }
        init();

        function login(requestData) {
            var deferred = $q.defer(), requestData = requestData || {};

            $http({
                method: "POST",
                url: apiUrl.loginUrl,
                data: requestData,
                beforeSend: function () {
                    callLoading(true);
                },
                complete: function () {
                    callLoading(false);
                }

            }).then(function (result) {
                if (result.data.error_code === 0) {
                   clearInterval(int);
                    userInfo = {
                        accessToken: result.data.access_token,
                        userData: result.data
                    };
                    $window.sessionStorage["userInfo"] = JSON.stringify(userInfo);
                    deferred.resolve(userInfo);
                } else {
                    var message = $filter('translate')('error_' + result.data.error_code)
                    popupOpen(message);
                    deferred.resolve({status:0});
                }


            }, function (error) {
                deferred.reject(error);
            });

            return deferred.promise;
        }

        function getUserInfo() {
            return userInfo;
        }

        function logout() {
            var deferred = $q.defer();
            $http({
                method: "POST",
                url: apiUrl.logOutUrl,
                headers: {
                    "Access-Token": userInfo.accessToken
                }
            }).then(function (result) {
                if (result.data.error_code === 0 || result.data.error_code === 1007) {

                    $window.sessionStorage["userInfo"] = null;
                    userInfo = null;
                    $rootScope.isLogedIn = false;
                    deferred.resolve(result);
                }
            }, function (error) {
                deferred.reject(error);
            });

            return deferred.promise;
        }

        function changePassword(data) {
            var deferred = $q.defer();
            $http({
                method: "POST",
                data: data,
                url: apiUrl.changePassword,
                headers: {
                    "Access-Token": userInfo.accessToken
                },
                beforeSend: function () {
                    callLoading(true);
                },
                complete: function () {
                    callLoading(false);
                }
            }).then(function (result) {
                if (result.data.error_code === 0) {
                    deferred.resolve(result);
                } else if (result.data.error_code === 1007) {
                    logout();
                } else {
                    var message = $filter('translate')('error_' + result.data.error_code);
                    popupOpen(message);
                }
            }, function (error) {
                deferred.reject(error);
            });

            return deferred.promise;
        }


        return {
            login: login,
            logout: logout,
            changePassword: changePassword,
            getUserInfo: getUserInfo
        };
    }]);


