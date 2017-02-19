cabinetControllers.controller('MyaccountCtrl', ["$scope", "$location", "$window", "BonusSvc", "StorageSvc", function ($scope, $location, $window, BonusSvc, StorageSvc) {

        $scope.BonusPoints = '';
        getMtsBonusPoints();
        function getMtsBonusPoints() {
            BonusSvc.getMtsBonusPoints().then(function (data) {
                $scope.BonusPoints = data.BonusPoints;

            }), function () {

            };
        }


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
        var today = dd + '/' + mm + '/' + yyyy;
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
            to: today
        };
        var propertyName = 'historyList';
        $scope[propertyName] = [];
        $scope.find = function () {
            getHistory();
        };

        function getHistory() {
            BonusSvc.getMTSBonusHistory($scope.account).then(function (data) {


                if (angular.isArray(data.MTSBonusActionRecord)) {
                    $scope[propertyName] = data.MTSBonusActionRecord;
                } else if (angular.isObject(data.MTSBonusActionRecord)) {
                    var arr = [];
                    arr.push(data.MTSBonusActionRecord);
                    $scope[propertyName] = arr;
                }

            }), function () {

            };
        }
        getHistory();



        $scope.isDisabled = function (from, to) {

            var fromArray = from.split("/"),
                    toArray = to.split("/");

            from = new Date(parseInt(fromArray[2], 10),
                    parseInt(fromArray[1], 10) - 1,
                    parseInt(fromArray[0], 10));
            to = new Date(parseInt(toArray[2], 10),
                    parseInt(toArray[1], 10) - 1,
                    parseInt(toArray[0], 10));
            //  from = new Date(from);
            //  to = new Date(to);
            return !(from < to);
        };
    }]);

