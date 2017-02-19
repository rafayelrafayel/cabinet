cabinetControllers.controller('NavmenuCtrl', ["$scope", "$window", "StorageSvc", "AuthenticationSvc", "$location","StorageSvc", 
    function ($scope, $window, StorageSvc, AuthenticationSvc, $location,StorageSvc) {
   
          

        $scope.isActive = function (viewLocation, childs) {
            var childs = childs || [];
            var bool = false;
            if (viewLocation === $location.path()) {
                bool = true;
            } else if (childs.length > 0 && childs.indexOf($location.path()) > -1) {
                bool = true;
            }
            return  bool;
           
        };
    }]);

