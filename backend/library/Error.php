<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Error
 *
 * @author Rafayel Khachatryan
 */

namespace library;

class Error {

    const INVALIDJSONCODE = 1002;
    const EMPTYJSONCODE = 1003;
    const INVALIDJSONMESSAGE = 'Invalid json data';
    const EMPTYJSONMESSAGE = 'Invalid json data';
    const RECIEVEDDATAFROMAPINOTOBJECTMESSAGE = 'Recieved data from Api is not object';
    const RECIEVEDDATAFROMAPINOTOBJECTCODE = 1004;
    
    const APISTATUSCODENOTHANDLEDMESSAGE = 'Status code not handled  yet';
    
    const APISTATUSCODENOTHANDLEDCODE = 1005;
    const LOGOUTFAILED = 'Loqout failed';
    const LOGOUTFAILEDCODE = 1006;
    
    const INVALIDTOKENMESSAGE = 'Invalid token';
    const INVALIDTOKENCODE = 1007;
    
    const INVALIDACCOUNTMESSAGE = "Invalid account";
    const INVALIDACCOUNTCODE = 1008;
    
    const PHONENUMBERMISSINGMESSAGE = "Phone number missing";
    const PHONENUMBERMISSING = 1009;
    const OPERATIONFAILEDMESSAGE = 'Operation failed';
    
    const OPERATIONFAILEDCODE = 1010;
    
    const EMPTYPARAMETRMESSAGE = 'Empty Data';
    const EMPTYPARAMETRCODE = 1011;
    
    const SOAPFAILEDMESSAGE = "Soap call failed";
    const SOAPFAILEDCODE = 1012;
    
    const FROMTODATEERRORMESSAGE = "From bigger  or equal to";
    const FROMTODATEERRORMCODE = 1013;
    
     const PASSWORDMESSAGE = "Password length less than 6";
    const PASSWORDCODE = 1014;
    
     const SUSPENDMESSAGE = "Account suspended";
    const SUSPENDCODE = 1015;
    
    

    public static $APISTATUSCODES = [
    ];

}
