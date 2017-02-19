<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AccountManagement
 *
 * @author Rafayel Khachatryan
 */

namespace models;

use helpers\SoapClientClass;

class AccountManagement {

    //NEW DAY PART

    public static function getNewDayParam() {

        $result = SoapClientClass::call('getNewDayParam');
        return \helpers\Common::isSuccessFromObject($result, 'getNewDayParam', 'object');
    }

    public static function getTariffPlanById($id) {
        $result = SoapClientClass::call('getTariffPlanById', [
                    'tariffPlanId' => $id
        ]);
        if (is_object($result) && $result->getTariffPlanByIdResult->ResultCode == '0') {
            return (array) $result->getTariffPlanByIdResult->TariffPlanResp;
        } else {
            throw new \Exception('Api error', $result->getCollectCallNumberListResult->ResultCode);
        }
    }

    public static function addNewDay($amount) {
        self::isSuspended();
        $phoneNumber = \models\Authentication::getPropertyFromStorage('phoneNumber');

        if (ServiceManagement::checkAccount()) {

            $result = SoapClientClass::call('addNewDay', [
                        'phoneNumber' => $phoneNumber,
                        'amount' => $amount
            ]);
            return \helpers\Common::isSuccessFromObject($result, 'addNewDay');
        } else {
            throw new \Exception(\library\Error::INVALIDACCOUNTMESSAGE, \library\Error::INVALIDACCOUNTCODE);
        }
    }

    public static function getNewDayValidity() {
        $phoneNumber = \models\Authentication::getPropertyFromStorage('phoneNumber');

        // if (self::checkAccount()) {
        $result = SoapClientClass::call('getNewDayValidity', [
                    'phoneNumber' => $phoneNumber,
        ]);

        return \helpers\Common::isSuccess($result, 'getNewDayValidity');
        /* } else {
          throw new \Exception(\library\Error::INVALIDACCOUNTMESSAGE, \library\Error::INVALIDACCOUNTCODE);
          } */
    }

    //Transfer
    public static function transferAmount($recipientPhoneNumber, $amount) {
        self::isSuspended();
        $phoneNumber = \models\Authentication::getPropertyFromStorage('phoneNumber');
        if (!(!!$recipientPhoneNumber) || !(!!$amount)) {
            throw new \Exception(\library\Error::PHONENUMBERMISSINGMESSAGE, \library\Error::PHONENUMBERMISSING);
        }

        if (ServiceManagement::checkAccount()) {
            $result = SoapClientClass::call('transferAmount', [
                        'phoneNumber' => $phoneNumber,
                        'recipientPhoneNumber' => $recipientPhoneNumber,
                        'amount' => $amount,
            ]);

            return \helpers\Common::isSuccess($result, 'transferAmount');
        } else {
            throw new \Exception(\library\Error::INVALIDACCOUNTMESSAGE, \library\Error::INVALIDACCOUNTCODE);
        }
    }

    public static function isSuspended() {
        $status = \models\Authentication::getPropertyFromStorage('LyfeCycleStatus');
        $isPrepaid = \models\Authentication::getPropertyFromStorage('isPrepaid');
      //  $status = 1;
        
        if (($status === 1 || $status === 2)){
            return true;
        }
        
       
        throw new \Exception(\library\Error::SUSPENDMESSAGE, \library\Error::SUSPENDCODE);
    }

}
