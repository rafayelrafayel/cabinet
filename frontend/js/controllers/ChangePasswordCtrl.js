cabinetControllers.controller('ChangePasswordCtrl', ["$scope", "$location", "AuthenticationSvc", "$filter", function ($scope, $location, AuthenticationSvc, $filter) {


  
        $scope.minlength = 8;
        $scope.maxlength = 12;
        $scope.regex = '^((?=.*[a-z]).{8,12})$';
        //console.log($window.sessionStorage);
        $scope.changepassword = {
            oldPassword: '',
            newPassword: '',
            newPasswordRepeat: ''

        };


        $scope.changePassword = function () {
            AuthenticationSvc.changePassword($scope.changepassword).then(function () {
                var mess = $filter('translate')('success_mess');
                popupOpen(mess);
                $scope.changepassword = {
                    oldPassword: '',
                    newPassword: '',
                    newPasswordRepeat: ''

                };
            }), function () {
                $location.path("/login");
            };

        };

    }]);

