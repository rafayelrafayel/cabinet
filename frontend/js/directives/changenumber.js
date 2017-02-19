'use strict';

/* Directives */
/**
 * author Rafayel Khachatryan
 * @param {type} 
 * @param {type} 
 */


cabinetApp.directive('editNumber', function () {
    return {
        restrict: 'EA',
        templateUrl: 'views/renders/forms/_editNumber.html',
        scope: {
            list: '=editNumber',
            type: '@type'
        },
        controller: ["$scope", "$element", "ServiceManagementSvc", "$location", "$route", "$timeout", "$window", "$filter",
            function ($scope, $element, ServiceManagementSvc, $location, $route, $timeout, $window, $filter) {

                var availablePrefixes = [
                    '77',
                    '93',
                    '94',
                    '98',
                    '41',
                    '43',
                    '55',
                    '91',
                    '95',
                    '96',
                    '99'
                ];
                var oldValue = angular.copy($scope.list);
                $scope.changeNumber = function (callList) {

                    if (jQuery.inArray($scope.list.value.substr(0, 2), availablePrefixes) === -1) {
                        var mess = $filter('translate')('error_-5');
                        popupOpen(mess);
                        return  false;
                    }

                  
                   // return false;
                    ServiceManagementSvc.changeNumberFromList({
                        newNumber: $scope.list.value,
                        oldNumber: oldValue.value,
                        callList: callList
                    }).then(function () {
                        oldValue = angular.copy($scope.list);
                        $scope.$parent.showDetails = false;
                        $route.reload();
                    }), function () {
                        $location.path("/callfriend");
                    };
                };

                $scope.cancelModify = function () {
                    $route.reload();
                };



            }]
    };
});