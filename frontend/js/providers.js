// Api Url List

var ApiUrls = angular.module('ApiUrlsProvider', []);
ApiUrls.value('apiUrl', {
    loginUrl: '../backend/login',
    logOutUrl: '../backend/login/logout',
    addToBlockList: '../backend/service/addtoblocklist',
    addToFavoriteList: '../backend/service/addtofavoritelist',
    addToWhiteList: '../backend/service/addtowhitelist',
    getNumbersList: '../backend/service/getnumberslist',
    unBlockFromList: '../backend/service/unblockfromlist',
    replaceNumberInList: '../backend/service/replacenumberinlist',
    blockAll: '../backend/service/blockall',
    unBlockAll: '../backend/service/unblockall',
    isBlockedForAll: '../backend/service/isblockedforall',
    forward: '../backend/service/forward',
    cancelForward: '../backend/service/cancelforward',
    getCallForwardInfo: '../backend/service/getcallforwardinfo',
    addNewDay: '../backend/account/addnewday',
    tranferMoney: '../backend/account/tranfermoney',
    changePassword: '../backend/login/changepassword',
    getNewDayParam: '../backend/account/getnewdayparam',
    getMtsBonusPoints: '../backend/bonus/getmtsbonuspoints',
    getMtsBonusList: '../backend/bonus/getmtsbonuslist',
    convertMtsBonusPoints: '../backend/bonus/convertmtsbonuspoints',
    getMTSBonusHistory: '../backend/bonus/getmtsbonushistory',
    sendMessageDetailedBill: '../backend/bonus/handledetailedbill'
});


