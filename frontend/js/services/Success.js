
    var SuccessModule = angular.module('SuccessModule', []);
    SuccessModule.factory("SuccessMvc", ["$location","AuthenticationSvc","$filter",function ($location, AuthenticationSvc,$filter) {


        function handleMessage(result,url) {
          //  console.log(url);
          
            if(url.indexOf('get') === -1 && url.indexOf('isblockedforall') === -1){
                var mess = $filter('translate')('success_mess');
                popupOpen(mess);
            }
        }

        return {
            handleMessage: handleMessage
        };
    }]);


