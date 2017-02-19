cabinetControllers.controller('CallfriendCtrl', ["$scope", "$location", "ServiceManagementSvc", "ErrorSvc", "$timeout", "$window", "$filter",
    function ($scope, $location, ServiceManagementSvc, ErrorSvc, $timeout, $window, $filter) {
        var availablePrefixes = [
            '077',
            '093',
            '094',
            '098',
            '041',
            '043',
            '055',
            '091',
            '095',
            '096',
            '099'
        ];

        $scope.block = {
            phoneNumber: ''
        };


        $scope.isBlockedService = false;
        $scope.white = {
            phoneNumber: ''
        };
        $scope.favorite = {
            phoneNumber: ''
        };

        function getnumberList(type) {
            ServiceManagementSvc.getNumberList({requestedList: type}).then(function (data) {
                // console.log(data);
                var propertyName = 'blacklist';
                if (type === 'FavoriteList') {
                    propertyName = 'favoritelist';
                }
                if (type === 'WhiteList') {
                    propertyName = 'whitelist';
                }
                if (angular.isArray(data.KeyValuePairOfintstring)) {
                    $scope[propertyName] = data.KeyValuePairOfintstring;
                } else if (angular.isObject(data.KeyValuePairOfintstring)) {
                    var arr = [];
                    arr.push(data.KeyValuePairOfintstring);
                    $scope[propertyName] = arr;
                } else {
                    $scope[propertyName] = [];
                }
            }), function (error) {
                ErrorSvc.handleErrors(error);
            };
        }

        reloadLists();

        __fireKeyBord();
        function __fireKeyBord() {

            $timeout(function () {
                angular.element(document).find('input').first().focus();
            }, 800);
        }
        $scope.fireKeyBord = function ($event) {

            // angular.element($event.target).parent().parent().find('.edit_number_input').focus();
            $timeout(function () {
                angular.element($event.target).parent().parent().find('.edit_number_input').focus();
                /*  var element = $window.document.getElementById('phoneNumber_');
                 
                 if (element)
                 element.focus();*/
            });
        }




        $scope.addToBlock = function (phoneNumber) {

            var phoneNumber = phoneNumber || undefined;
            if (undefined !== phoneNumber) {
                $scope.block.phoneNumber = phoneNumber;
            }
           
                //&& $scope.block.phoneNumber.substr(1, 2) !== availablePrefixes[i].substr(1, 2)
                if (jQuery.inArray($scope.block.phoneNumber.substr(0, 3),availablePrefixes) === -1) {
                    var mess = $filter('translate')('error_-5');
                    popupOpen(mess);
                    return  false;
                }
           

         

            ServiceManagementSvc.addToBlockList($scope.block).then(function () {
                reloadLists();
                $scope.block = {
                    phoneNumber: ''
                };

            }), function () {

            };
        };

        $scope.addToWhite = function () {
            
             if (jQuery.inArray($scope.white.phoneNumber.substr(0, 3),availablePrefixes) === -1) {
                    var mess = $filter('translate')('error_-5');
                    popupOpen(mess);
                    return  false;
                }
            
            
            ServiceManagementSvc.addToWhiteList($scope.white).then(function () {
                reloadLists();
                $scope.white = {
                    phoneNumber: ''
                };

            }), function () {

            };
        };

        $scope.unBlockFromList = function (phoneNumber) {
            ServiceManagementSvc.unBlockFromList({phoneNumber: phoneNumber}).then(function () {
                reloadLists();

            }), function () {
                //if there is an error
            };
        };

        $scope.addToFavorite = function () {
            
            if (jQuery.inArray($scope.favorite.phoneNumber.substr(0, 3),availablePrefixes) === -1) {
                    var mess = $filter('translate')('error_-5');
                    popupOpen(mess);
                    return  false;
                }
            ServiceManagementSvc.addToFavoriteList($scope.favorite).then(function () {
                reloadLists();
                $scope.favorite = {
                    phoneNumber: ''
                };

            }), function () {

            };
        };

        function reloadLists() {
            getnumberList('BlackList');
            getnumberList('FavoriteList');
            getnumberList('WhiteList');
        }

        isBlockedService();
        function isBlockedService() {
            ServiceManagementSvc.isBlockedForAll().then(function (data) {
                //  console.log(12);
                if (data.error_code === 0) {
                    $scope.isBlockedService = true;
                } else {
                    $scope.isBlockedService = false;
                }
            }), function (data) {

            };
        }

        $scope.blockAll = function () {
            ServiceManagementSvc.blockAll().then(function () {
                reloadLists();
                isBlockedService();
                // console.log($scope.isBlockedService);
            }), function () {

            };
        };

        $scope.unBlockAll = function () {
            ServiceManagementSvc.unBlockAll().then(function () {
                reloadLists();
                isBlockedService();
            }), function () {

            };
        };

        return {
            reloadLists: reloadLists
        };
    }]);

