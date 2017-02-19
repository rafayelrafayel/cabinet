'use strict';

/* App Module */



var cabinetApp = angular.module('cabinetApp', [
    'ngRoute',
    //'contactsAnimations',
    'angular.filter',
    'angularSelectbox',
    //new part
    'ApiUrlsProvider',
    'ui.bootstrap',
    'ui.mask',
    'pascalprecht.translate',
    'cabinetControllers',
    'AuthenticationServicesModule',
    'ServiceManagementModule',
    'AccountManagementModule',
    'ErrorModule',
    'ngIdle',
    'ngSanitize',
    'BonusModule',
    'ClockModule',
    'SuccessModule',
    'StorageServicesModule'
]);


cabinetApp.config(['$routeProvider', '$translateProvider', "$httpProvider", "IdleProvider", "KeepaliveProvider",
    function ($routeProvider, $translateProvider, $httpProvider, IdleProvider, KeepaliveProvider) {
        $routeProvider.
                when('/login', {
                    templateUrl: 'views/login/index.html',
                    controller: 'LoginCtrl'
                            // reloadOnSearch: true,
                }).
                when('/serviceManagement', {
                    templateUrl: 'views/serviceManagement/index.html',
                    controller: 'ServiceManagementCtrl',
                    resolve: resolver(false)

                }).
                when('/callfriend', {
                    templateUrl: 'views/serviceManagement/callfriend.html',
                    controller: 'CallfriendCtrl',
                    resolve: resolver(false)

                }).
                when('/callforwarding', {
                    templateUrl: 'views/serviceManagement/callforwarding.html',
                    controller: 'CallForwardingCtrl',
                    resolve: resolver(false)

                }).
                when('/accountManagement', {
                    templateUrl: 'views/accountManagement/accountManagement.html',
                    controller: 'AccountManagementCtrl',
                    resolve: resolver(false)

                }).
                when('/newday', {
                    templateUrl: 'views/accountManagement/newday.html',
                    controller: 'NewdayCtrl',
                    resolve: resolver(false)

                }).when('/detailedbill', {
            templateUrl: 'views/accountManagement/detailedbill.html',
            controller: 'DetailedbillCtrl',
            resolve: resolver(false)

        }).
                when('/poghancum', {
                    templateUrl: 'views/accountManagement/poghancum.html',
                    controller: 'PoghancumCtrl',
                    resolve: resolver(false)

                }).
                when('/changepassword', {
                    templateUrl: 'views/login/changepassword.html',
                    controller: 'ChangePasswordCtrl',
                    resolve: resolver(false)

                }).
                when('/bonus', {
                    templateUrl: 'views/bonus/bonus.html',
                    controller: 'BonusCtrl',
                    resolve: resolver(false)

                }).
                when('/convertbonus', {
                    templateUrl: 'views/bonus/convertbonus.html',
                    controller: 'ConvertbonusCtrl',
                    resolve: resolver(false)

                }).
                when('/myaccount', {
                    templateUrl: 'views/bonus/myaccount.html',
                    controller: 'MyaccountCtrl',
                    resolve: resolver(false)

                }).
                when('/contacts/:id/edit', {
                    templateUrl: 'partials/contacts-edit.html',
                    controller: 'ContactsEditCtrl'
                }).
                otherwise({
                    redirectTo: '/login'
                });

        //  $translateProvider.useSanitizeValueStrategy('sanitize');
        $translateProvider.useStaticFilesLoader({
            prefix: 'languages/',
            suffix: '.json'
        });
        $translateProvider.preferredLanguage('am');


        // Register interceptors service
        $httpProvider.interceptors.push('interceptors');


        // IdleProvider.idle(15); // 30 seconds idle
        //   IdleProvider.timeout(15); // after 1 seconds idle, time the user out
        // KeepaliveProvider.interval(5 * 60); // 5 minute keep-alive ping

    }
]);

cabinetApp.run(["$rootScope", "$location", "StorageSvc", "$window", "$translate", "AuthenticationSvc", "Idle", "$uibModal", "ClockSvc", "$timeout",
    function ($rootScope, $location, StorageSvc, $window, $translate, AuthenticationSvc, Idle, $uibModal, ClockSvc, $timeout) {

        checkScroll();

        //load current lang Json
        getCurrentLang($translate);

        Idle.watch();


        function _fireKeyBord() {

            $timeout(function () {
                angular.element(document).find('input').first().each(function () {
                    if (!$(this).parent().hasClass('date')) {
                        $(this).focus();
                    }
                })
            });
        }

        //  console.log(StorageSvc.getStorage());
        var clockFlag = '';
        $rootScope.$on("$routeChangeSuccess", function (userInfo) {
            checkScroll();
           // console.log($location.url());
            if ($location.url() !== '/callforwarding') {
                _fireKeyBord();
            }

            $rootScope.isLogedIn = StorageSvc.isNotEmpty();
            $rootScope.IsPrepaid = StorageSvc.getProperty('IsPrepaid', 'userData');


            var clock = undefined;
            if (!$rootScope.isLogedIn) {
                if (clockFlag !== 'trueNotLogin') {
                    clock = null;
                    clock = ClockSvc.injectClockWithoutLogIn($uibModal, true);
                    clockFlag = 'trueNotLogin';
                }

            } else {
                if (clockFlag !== 'trueLogin') {
                    clock = null;
                    clock = ClockSvc.injectClockWithoutLogIn($uibModal);
                    clockFlag = 'trueLogin';
                }

            }

        });
        $rootScope.$on("$routeChangeError", function (event, current, previous, eventObj) {
            if (eventObj.authenticated === false) {
                $location.path("/login");
            }
        });



//        $rootScope.$on('IdleTimeout', function () {
//            var homePage = 'http://localhost:8002/index';
//            if ($rootScope.isLogedIn) {
//                AuthenticationSvc.logout().then(function () {
//                    $window.location.href = homePage;
//                    // $location.path("/login");
//                }), function () {
//                    console.log('Failed Logout');
//                };
//            } else {
//                $window.location.href = homePage;
//            }
//
//        });
//        var modalInstance = null;
//        $rootScope.$on('IdleStart', function () {
//            modalInstance = $uibModal.open({
//                templateUrl: 'views/uib/index.html',
//                windowClass: 'modal-danger'
//            });
//        });
//
//        $rootScope.$on('IdleEnd', function () {
//            ClockSvc.resetClock(clock);
//            ClockSvc.injectClockWithoutLogIn();
//            modalInstance.dismiss();
//        });

    }]);


