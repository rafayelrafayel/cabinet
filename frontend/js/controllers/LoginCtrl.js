cabinetControllers.controller('LoginCtrl', [
    "$scope", "$location", "$window", "StorageSvc", "AuthenticationSvc", "$timeout", "$route",
    function ($scope, $location, $window, StorageSvc, AuthenticationSvc, $timeout, $route) {

        $scope.selectData = [
            {
                "id": 77,
                "label": "077"
            },
            {
                "id": 93,
                "label": "093"
            },
            {
                "id": 94,
                "label": "094"
            },
            {
                "id": 98,
                "label": "098"
            },
            {
                "id": 41,
                "label": "041"
            },
            {
                "id": 43,
                "label": "043"
            },
            {
                "id": 55,
                "label": "055"
            },
            {
                "id": 91,
                "label": "091"
            },
            {
                "id": 95,
                "label": "095"
            },
            {
                "id": 96,
                "label": "096"
            },
            {
                "id": 99,
                "label": "099"
            }



        ];

        $scope.collectionSelected = 77;
        $scope.change = function (value) {
            $scope.login.phoneCode = value;
        }



        //alert($window.innerWidth);
        if (StorageSvc.isNotEmpty()) {
            $location.path("/serviceManagement");
        }
        //console.log($window.sessionStorage);
        $scope.login = {
            phoneNumber: '',
            password: ''

        };


//  NU73AivS
//94327860

        $scope.loginUser = function () {

            var oldNumber = angular.copy($scope.login);


            $scope.login.phoneNumber = $scope.login.phoneCode + $scope.login.phoneNumber;

           // console.log($scope.login);
           // return false;

            AuthenticationSvc.login($scope.login).then(function (data) {

                $scope.login = oldNumber;

                if (!(data.hasOwnProperty('status') && data.status === 0)) {
                    $location.path("/serviceManagement");
                    //$window.location.reload();
                }



            }), function () {


                $location.path("/login");
            };

        };


        $scope.hideForm = function () {

        }






    }]);

