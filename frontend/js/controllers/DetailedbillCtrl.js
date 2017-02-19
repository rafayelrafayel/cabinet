cabinetControllers.controller('DetailedbillCtrl', ["$scope", "$location", "$window", "BonusSvc", "StorageSvc", "AccountManagementSvc", function ($scope, $location, $window, BonusSvc, StorageSvc, AccountManagementSvc) {
        var today = new Date();
        var dd = today.getDate();
        var mm = today.getMonth() + 1; //January is 0!
          var _mm = today.getMonth(); //January is 0!

        var yyyy = today.getFullYear();
        if (dd < 10) {
            dd = '0' + dd;
        }
        if (mm < 10) {
            mm = '0' + mm;
             _mm = '0' + _mm;
        }
        var today = dd + '/' +  mm + '/' + yyyy;
        var firstDayInMonth = dd + '/' + _mm + '/' + yyyy;


        jQuery(function () {
            var language = getParameterByName('lang');
            if (null === language) {
                language = 'am';
            }
            $('#datepicker').datepicker({
                autoclose: true,
                 format: 'dd/mm/yyyy',
                language: language

            }).on("changeDate", function (e) {
                // console.log(e.date);
            });

            $('#datepicker2').datepicker({
                autoclose: true,
                 format: 'dd/mm/yyyy',
                language: language
            });

        });
        $scope.account = {
            from: firstDayInMonth,
            to: today,
            email: ''
        };
        $scope.regex = '^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$';

        $scope.isDisabled = function (from, to, boolean) {
            var fromArray = from.split("/"),
             toArray = to.split("/");
          
            from = new Date(parseInt(fromArray[2], 10),
                  parseInt(fromArray[1], 10) - 1,
                  parseInt(fromArray[0], 10));
            to = new Date(parseInt(toArray[2], 10),
                  parseInt(toArray[1], 10) - 1,
                  parseInt(toArray[0], 10));
            //   console.log(from,to);
           

            return !(from < to) || boolean;
        };

        $scope.sendMessage = function () {
            AccountManagementSvc.sendMessage($scope.account).then(function () {
                $scope.account = {
                    from: firstDayInMonth,
                    to: today,
                    email: ''
                };
            }, function () {

            });

        };

    }]);

