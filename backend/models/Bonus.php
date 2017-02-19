<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace models;

use helpers\SoapClientClass;

/**
 * Description of Bonus
 *
 * @author Rafayel Khachatryan
 */
class Bonus {

    //getMTSBonusList
    public static function getMTSBonusList() {

        $result = SoapClientClass::call('getMTSBonusList');

        if (is_object($result) && $result->getMTSBonusListResult->ResultCode == '0') {
            return $result->getMTSBonusListResult->MTSBonusPrizes;
        } else {
            throw new \Exception('Api error', $result->getMTSBonusListResult->ResultCode);
        }
    }

    //getMTSBonusPoints
    public static function getMTSBonusPoints() {
        $phoneNumber = \models\Authentication::getPropertyFromStorage('phoneNumber');

        $result = SoapClientClass::call('getMTSBonusPoints', [
                    'phoneNumber' => $phoneNumber,
        ]);

        return \helpers\Common::isSuccessFromObject($result, 'getMTSBonusPoints', 'object');
    }

    //isRegisteredToMTSBonus
    private static function isRegisteredToMTSBonus() {
        $phoneNumber = \models\Authentication::getPropertyFromStorage('phoneNumber');

        $result = SoapClientClass::call('isRegisteredToMTSBonus', [
                    'phoneNumber' => $phoneNumber,
        ]);

        return \helpers\Common::isSuccessFromObject($result, 'isRegisteredToMTSBonus');
    }

    //convertMTSBonusPoints
    public static function convertMTSBonusPoints($prizeId) {
        AccountManagement::isSuspended();
        if (\models\ServiceManagement::checkAccount() && self::isRegisteredToMTSBonus()) {

            $phoneNumber = \models\Authentication::getPropertyFromStorage('phoneNumber');
            $result = SoapClientClass::call('convertMTSBonusPoints', [
                        'phoneNumber' => $phoneNumber,
                        'PrizeId' => $prizeId
            ]);
            return \helpers\Common::isSuccess($result, 'convertMTSBonusPoints');
        } else {

            throw new \Exception(\library\Error::INVALIDACCOUNTMESSAGE, \library\Error::INVALIDACCOUNTCODE);
        }
    }

    //getMTSActiveBonusList
    public static function getMTSActiveBonusList() {
        $phoneNumber = \models\Authentication::getPropertyFromStorage('phoneNumber');

        $result = SoapClientClass::call('getMTSActiveBonusList', [
                    'phoneNumber' => $phoneNumber,
        ]);
        if (is_object($result) && $result->getMTSActiveBonusListResult->ResultCode == '0') {
            return $result->getMTSActiveBonusListResult->ActiveMTSBonusList;
        } else {
            throw new \Exception('Api error', $result->getMTSBonusListResult->ResultCode);
        }
    }

    //getMTSBonusHistory

    public static function getMTSBonusHistory($from, $to) {
        $phoneNumber = \models\Authentication::getPropertyFromStorage('phoneNumber');

        $result = SoapClientClass::call('getMTSBonusHistory', [
                    'phoneNumber' => $phoneNumber,
                    'from' => $from,
                    'to' => $to,
        ]);
        if (is_object($result) && $result->getMTSBonusHistoryResult->ResultCode == '0') {
            return $result->getMTSBonusHistoryResult->MTSBonusActionRecords;
        } else {
            throw new \Exception('Api error', $result->getMTSBonusListResult->ResultCode);
        }
    }

    public static function getDetailedBill($email, $from, $to, $langId) {
        AccountManagement::isSuspended();

        $phoneNumber = \models\Authentication::getPropertyFromStorage('phoneNumber');

        $result = SoapClientClass::call('GetAccountInvoices', [
                    'phoneNumber' => $phoneNumber,
                    'email' => $email,
                    'subInvoce' => 'DetailedBill',
                    'from' => $from,
                    'to' => $to,
                    'langId' => $langId,
        ]);

        return \helpers\Common::isSuccess($result, 'getAccountInvoices');
    }

}
