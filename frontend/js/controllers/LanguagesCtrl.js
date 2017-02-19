cabinetControllers.controller('LanguagesCtrl', ["$scope", "$location", "$window", "$translate", function ($scope, $location, $window, $translate) {
        $scope.changeLanguage = function (_lang) {
            var lang = getParameterByName('lang');
            var $get = '', absUrl = $location.absUrl();
            if (null === lang) {
                $get += '?lang=' + _lang;
            } else {
                absUrl = absUrl.replace(/\?lang=[a-z]{2}/gmi, "");
                $get += '?lang=' + _lang;
            }

            $translate.use(_lang);
            $window.location.assign(absUrl + $get);
        };


        $scope.isActive = function (lang) {
            return lang === getParameterByName('lang');
        };
    }]);

