'use strict';

/* Directives */
/**
 * author Rafayel Khachatryan
 * @param {type} 
 * @param {type} 
 */

cabinetApp.directive('loading', ['$http', function ($http)
    {
        return {
            restrict: 'A',
            link: function (scope, elm, attrs)
            {
                scope.isLoading = function () {
                    return $http.pendingRequests.length > 0;
                };

                scope.$watch(scope.isLoading, function (v)
                {
                    if (v) {
                        elm.show();
                    } else {
                        elm.hide();
                    }
                });
            }
        };

    }]);