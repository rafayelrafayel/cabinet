cabinetControllers.controller('ConvertbonusCtrl', ["$scope", "$location", "$window", "BonusSvc", "StorageSvc", function ($scope, $location, $window, BonusSvc, StorageSvc) {


        //console.log($window.sessionStorage);

        $scope.BonusPoints = '';
        $scope.convertBonus = {
            PrizeId: ''
        }
        $scope.bonusList = [];
        function getMtsBonusPoints() {
            BonusSvc.getMtsBonusPoints().then(function (data) {
                $scope.BonusPoints = data.BonusPoints;

            }), function () {

            };
        }

        function getMtsBonusList() {
            BonusSvc.getMtsBonusList().then(function (data) {
                $scope.bonusList = data.MTSBonusPrizeList;
            }), function () {

            };
        }
        //console.log($scope.PrizeId);
        getMtsBonusPoints();
        getMtsBonusList();


        $scope.convert = function () {
            
            BonusSvc.convertMtsBonusPoints($scope.convertBonus).then(function () {
                $location.path("/bonus");
            }), function () {
                // $location.path("/login");
            };

        };
//TODO
        $scope.isDisabled = function (id) {
            return false;
        };

        $scope.checkRadio = function ($event,bonus) {
        $scope.convertBonus.PrizeId =  bonus.PrizeId;
            var tr = jQuery($event.target).parent(), body = tr.parent();
            clearSelected();
            if (tr.hasClass('selected')) {
                tr.removeClass('selected');
            } else {
                tr.addClass('selected');
            }



            function clearSelected() {
                body.find('tr').removeClass('selected');
            }
            function click2radio() {
               // tr.find('input').click();
            }
           // console.log();
            //angular.element(element).addClass('active');
//            if(!angular.element(element).hasClass('active')){
//                 angular.element(element).addClass('active');
//            }

        };

    }]);

