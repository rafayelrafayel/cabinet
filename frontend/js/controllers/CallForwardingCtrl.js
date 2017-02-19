cabinetControllers.controller('CallForwardingCtrl', ["$scope", "$location", "ServiceManagementSvc", "ErrorSvc", "$filter","$route",
    function ($scope, $location, ServiceManagementSvc, ErrorSvc, $filter,$route) {


        $scope.forward = {
            CfuNumber: '',
            CfbNumber: '',
            CfnrcNumber: '',
            CfnryNumber: '',
            CfnrtTime: 5
        };
        
        
        $scope.oldvalue = { 
            CfuNumber: '',
            CfbNumber: '',
            CfnrcNumber: '',
            CfnryNumber: '',
            CfnrtTime: 5
        };
        var seconds = $filter('translate')('seconds');
        $scope.selectData = [
           /* {
                "id": -1,
                "label": "-----"
            },*/
            {
                "id": 5,
                "label": "5 " + seconds
            },
            {
                "id": 10,
                "label": "10 " + seconds
            },
            {
                "id": 15,
                "label": "15 " + seconds
            },
            {
                "id": 20,
                "label": "20 " + seconds
            },
            {
                "id": 25,
                "label": "25 " + seconds
            },
            {
                "id": 30,
                "label": "30 " + seconds
            }


        ];


       // $scope.collectionSelected = -1;//setTimeout(function () {return -1; }, 1000);
        
       // console.log( $scope.collectionSelected);
        $scope.change = function (value) {
            $scope.forward.CfnrtTime = value;
        };


        getCallForwardInfo();
        function getCallForwardInfo() {
            ServiceManagementSvc.getCallForwardInfo().then(function (data) {
                 $scope.collectionSelected =  "5 " + seconds;
                $scope.forward = data;
                 $scope.oldvalue = angular.copy(data);
                 //console.log(data);
                 
                 for (var i in $scope.selectData){
                     if($scope.selectData[i]['id'] === data.CfnrtTime){
                        
                           $scope.collectionSelected = $scope.selectData[i]['label'];
                           
                           //console.log($scope.collectionSelected );
                     }
                 } 

              // $scope.collectionSelected = (data.CfnrtTime === 0 ? '------' : data.CfnrtTime);
               
               console.log($scope.collectionSelected );
            }), function () {

            };
        }


        $scope.forwardNumbers = function () {
            if($scope.forward.CfnrtTime === 0){
                $scope.forward.CfnrtTime = 5;
            }
            //console.log($scope.forward);return false;
            ServiceManagementSvc.forward($scope.forward).then(function () {
                getCallForwardInfo();

            }), function () {

            };
        };


        $scope.isDisabled = function (param) {
           // console.log(($scope.oldvalue[param]));
            return  !(!!($scope.oldvalue[param]));

        };

        $scope.cancelForward = function (type, event) {
            event.preventDefault();
            ServiceManagementSvc.cancelForward({type: type}).then(function () {
                getCallForwardInfo();
                 $route.reload();
            }), function () {

            };
        };

    }]);

