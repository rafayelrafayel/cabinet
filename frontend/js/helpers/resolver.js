
var resolver = function (access) {

    return {
        auth: ["$q","AuthenticationSvc",function ($q, AuthenticationSvc) {
			
            if (access) {
                var deferred = $q.defer();
                deferred.resolve();
            } else {
                var userInfo = AuthenticationSvc.getUserInfo();
                if (userInfo) {
                    return $q.when(userInfo);
                } else {
                    return $q.reject({authenticated: false});
                }
            }

        }]
    }
}
