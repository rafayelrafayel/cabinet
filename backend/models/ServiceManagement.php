<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace models;

use helpers\SoapClientClass;

/**
 * Description of ServiceManagement
 *
 * @author Rafayel Khachatryan
 */
class ServiceManagement {

    public static function checkAccount() {
        $phoneNumber = \models\Authentication::getPropertyFromStorage('phoneNumber');
        $password = \models\Authentication::getPropertyFromStorage('password');
        if (!($phoneNumber) || !($password)) {
            throw new \Exception(\library\Error::INVALIDACCOUNTMESSAGE, \library\Error::INVALIDACCOUNTCODE);
        }

        $result = SoapClientClass::call('checkAccount', [
                    'phoneNumber' => $phoneNumber,
                    'passHash' => md5($password),
        ]);
       
        return \helpers\Common::isSuccess($result, 'checkAccount');
    }

    public static function addToFavoriteList($favoriteNumber) {
          AccountManagement::isSuspended();
        $phoneNumber = \models\Authentication::getPropertyFromStorage('phoneNumber');
        if (self::checkAccount()) {
            $result = SoapClientClass::call('collectCallAddNumberToFavoriteList', [
                        'phoneNumber' => $phoneNumber,
                        'favoriteNumber' => $favoriteNumber
            ]);
            return \helpers\Common::isSuccess($result, 'collectCallAddNumberToFavoriteList');
        } else {
            throw new \Exception(\library\Error::INVALIDACCOUNTMESSAGE, \library\Error::INVALIDACCOUNTCODE);
        }
    }

    public static function addToBlockList($xNumber) {
          AccountManagement::isSuspended();
        $phoneNumber = \models\Authentication::getPropertyFromStorage('phoneNumber');
        if (self::checkAccount()) {
            $result = SoapClientClass::call('collectCallBlockNumber', [
                        'phoneNumber' => $phoneNumber,
                        'xNumber' => $xNumber
            ]);

            return \helpers\Common::isSuccess($result, 'collectCallBlockNumber');
        } else {
            throw new \Exception(\library\Error::INVALIDACCOUNTMESSAGE, \library\Error::INVALIDACCOUNTCODE);
        }
    }

    /**
     * 
     * @param type $requestedList FavoriteList, BlackList,WhiteList
     * @return type
     * @throws \Exception
     */
    public static function getNumbersList($requestedList = '') {
        $phoneNumber = \models\Authentication::getPropertyFromStorage('phoneNumber');
        $result = SoapClientClass::call('getCollectCallNumberList', [
                    'phoneNumber' => $phoneNumber,//'94327860',
                    'requestedList' => $requestedList
        ]);
        if (is_object($result) && $result->getCollectCallNumberListResult->ResultCode == '0') {
            return $result->getCollectCallNumberListResult->CollectCallNumberList;
        } else {
            throw new \Exception('Api error', $result->getCollectCallNumberListResult->ResultCode);
        }
    }

    /**
     * 
     */
    public static function unBlockFromList($xNumber) {
          AccountManagement::isSuspended();
        $phoneNumber = \models\Authentication::getPropertyFromStorage('phoneNumber');

        if (self::checkAccount()) {
            $result = SoapClientClass::call('collectCallUnBlockNumber', [
                        'phoneNumber' => $phoneNumber,
                        'xNumber' => $xNumber
            ]);


            return \helpers\Common::isSuccess($result, 'collectCallUnBlockNumber');
        } else {
            throw new \Exception(\library\Error::INVALIDACCOUNTMESSAGE, \library\Error::INVALIDACCOUNTCODE);
        }
    }

    /**
     * @param type $callList FavoriteList, BlackList
     * CollectCallReplaceNumberInList
     * string phoneNumber, string newNumber, string oldNumber, CollectCallList callList, int clientId
     */
    public static function replaceNumberInList($newNumber, $oldNumber, $callList) {
          AccountManagement::isSuspended();
        $phoneNumber = \models\Authentication::getPropertyFromStorage('phoneNumber');
        if (self::checkAccount()) {
            $result = SoapClientClass::call('collectCallReplaceNumberInList', [
                        'phoneNumber' => $phoneNumber,
                        'newNumber' => $newNumber,
                        'oldNumber' => $oldNumber,
                        'callList' => $callList
            ]);
            return \helpers\Common::isSuccess($result, 'collectCallReplaceNumberInList');
        } else {
            throw new \Exception(\library\Error::INVALIDACCOUNTMESSAGE, \library\Error::INVALIDACCOUNTCODE);
        }
    }

    //Ask to Karen
    public static function isBlockedService() {
        $phoneNumber = \models\Authentication::getPropertyFromStorage('phoneNumber');

        $result = SoapClientClass::call('isCollectCallBlockedService', [
                    'phoneNumber' => $phoneNumber,
        ]);
       // print_r($result);
        return \helpers\Common::isSuccess($result, 'isCollectCallBlockedService');
    }

    public static function bloackAll() {
          AccountManagement::isSuspended();
        $phoneNumber = \models\Authentication::getPropertyFromStorage('phoneNumber');
        if (self::checkAccount()) {
            $result = SoapClientClass::call('collectCallBlockAllNumbers', [
                        'phoneNumber' => $phoneNumber
            ]);
            return \helpers\Common::isSuccess($result, 'collectCallBlockAllNumbers');
        } else {
            throw new \Exception(\library\Error::INVALIDACCOUNTMESSAGE, \library\Error::INVALIDACCOUNTCODE);
        }
    }

    public static function unBlockAll() {
          AccountManagement::isSuspended();
        $phoneNumber = \models\Authentication::getPropertyFromStorage('phoneNumber');
        if (self::checkAccount()) {
            $result = SoapClientClass::call('collectCallUnBlockAllNumbers', [
                        'phoneNumber' => $phoneNumber
            ]);
            return \helpers\Common::isSuccess($result, 'collectCallUnBlockAllNumbers');
        } else {
            throw new \Exception(\library\Error::INVALIDACCOUNTMESSAGE, \library\Error::INVALIDACCOUNTCODE);
        }
    }

    //Call Forwarding part


    public static function forward($cfu, $cfb, $cfnrc, $cfnry, $nrytime) {
          AccountManagement::isSuspended();
        $phoneNumber = \models\Authentication::getPropertyFromStorage('phoneNumber');
        if (self::checkAccount()) {
            $result = SoapClientClass::call('updateCF', [
                        'phoneNumber' => $phoneNumber,
                        'cfu' => $cfu,
                        'cfb' => $cfb,
                        'cfnrc' => $cfnrc,
                        'cfnry' => $cfnry,
                        'nrytime' => (int) $nrytime,
            ]);
            return \helpers\Common::isSuccess($result, 'updateCF');
        } else {
            throw new \Exception(\library\Error::INVALIDACCOUNTMESSAGE, \library\Error::INVALIDACCOUNTCODE);
        }
    }

    //cancelCF
    //type CFU,CFB,CFNRC,CFNRY
    public static function cancelForward($type) {
          AccountManagement::isSuspended();
        $phoneNumber = \models\Authentication::getPropertyFromStorage('phoneNumber');
        if (self::checkAccount()) {
            $result = SoapClientClass::call('cancelCF', [
                        'phoneNumber' => $phoneNumber,
                        'type' => $type,
            ]);
            return \helpers\Common::isSuccess($result, 'cancelCF');
        } else {
            throw new \Exception(\library\Error::INVALIDACCOUNTMESSAGE, \library\Error::INVALIDACCOUNTCODE);
        }
    }

    //getCFInformation
    public static function getCallForwardInfo() {
        $phoneNumber = \models\Authentication::getPropertyFromStorage('phoneNumber');

        $result = SoapClientClass::call('getCFInformation', [
                    'phoneNumber' => $phoneNumber,
        ]);
        
       // echo '<pre>';
       // print_r($result);
      //  echo '</pre>';die;
  
        if (is_object($result) && $result->getCFInformationResult->ResultCode == '0') {
            unset($result->getCFInformationResult->ResultCode);
            return $result->getCFInformationResult;
        } else {
            throw new \Exception('Api error', $result->getCFInformationResult->ResultCode);
        }
    }

    //suspendAccount
    public static function suspendAccount() {
        $phoneNumber = \models\Authentication::getPropertyFromStorage('phoneNumber');
        if (self::checkAccount()) {
            $result = SoapClientClass::call('suspendAccount', [
                        'phoneNumber' => $phoneNumber
                       
            ]);
            return \helpers\Common::isSuccess($result, 'suspendAccount');
        } else {
            throw new \Exception(\library\Error::INVALIDACCOUNTMESSAGE, \library\Error::INVALIDACCOUNTCODE);
        }
    }

}
