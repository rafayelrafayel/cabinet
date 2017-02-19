
var ClockModule = angular.module('ClockModule', []);
ClockModule.factory("ClockSvc", ["AuthenticationSvc", "$rootScope", "$window", function (AuthenticationSvc, $rootScope, $window) {


        function injectClockWithoutLogIn(obj, flag, fromCancel) {
            var fromCancel = fromCancel || false;
             $rootScope.clock = new FlipClock($('.my-clock'), getSeconds(), {
                clockFace: 'Counter'

            });
            if (flag === true) {
                $rootScope.clock.setTime(60);
            }

            setTimeout(function () {

                int = setInterval(function () {
                    if (null !== $rootScope.clock) {
                                $rootScope.clock.decrement();
                        var time =  $rootScope.clock.getTime().time;
                        if (time == 15) {
                            openModal(obj);
                        }
                        // console.log(time);
                        if (time <= 0) {
                            $rootScope.clock = null;
                            clearInterval(int);
                            // openModal(obj);
                            // openModal(obj);

                        }
                       
                    }

                }, 1000);



                // console.log(int);
            });
            return  $rootScope.clock;
        }

        function resetClock(clock) {
            return clock.reset();
        }

        function openModal(obj) {

            var modalInstance = obj.open({
                templateUrl: 'views/uib/index.html',
                windowClass: 'modal-danger',
                controller: 'ModalInstanceCtrl',
            });
            return modalInstance;
        }



        function clockLogout() {

            var homePage = 'http://localhost:8002/index';
            if ($rootScope.isLogedIn) {
                AuthenticationSvc.logout().then(function () {
                    $window.location.href = homePage;
                    // $location.path("/login");
                }), function () {
                    console.log('Failed Logout');
                };
            } else {
                $window.location.href = homePage;
            }
        }

        function getSeconds() {
            return 180;
        }




        return {
            injectClockWithoutLogIn: injectClockWithoutLogIn,
            resetClock: resetClock,
            clockLogout: clockLogout

        };
    }]);


