<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of User
 *
 * @author Rafayel Khachatryan
 */

namespace models;

class User {

    public static function login($loginData = []) {

        $result = \helpers\SoapClientClass::call('VerifyAndQueryAccount', $loginData);
        
       // print_r($result);die;

       


        if (is_object($result)) {
            $resultData = $result->verifyAndQueryAccountResult;
            if ($resultData->ResultCode == '0') {
               // print_r(AccountManagement::getTariffPlanById($resultData->TariffPlanInfo->TariffPlanId));die;
                $dataSession = [
                    'phoneNumber' => $loginData['phoneNumber'],
                    'password' => $loginData['password'],
                    'Balance' => $resultData->Balance,
                    'ChangeOwnershipDate' => $resultData->ChangeOwnershipDate,
                    'CreditLimit' => $resultData->CreditLimit,
                    'ExpiryDate' =>$resultData->ExpiryDate, //'2015-05-08T12:00:00', //
                    'FirstCallDate' => $resultData->FirstCallDate,
                    'IsCorporatePricePlan' => $resultData->IsCorporatePricePlan,
                    'IsPrepaid' => $resultData->IsPrepaid,
                    'LanguageID' => $resultData->LanguageID,
                    'LastModifiedDate' => $resultData->LastModifiedDate,
                    'LyfeCycleStatus' => $resultData->LyfeCycleStatus,
                    'RealIP' => $resultData->RealIP,
                    'RoamingLastBillDate' => $resultData->RoamingLastBillDate,
                    'RoamingUnbilled' => $resultData->RoamingUnbilled,
                    'SubPostDebt' => $resultData->SubPostDebt,
                    'SubscriberLastBillDate' => $resultData->SubscriberLastBillDate,
                    'TariffPlanInfo' => AccountManagement::getTariffPlanById($resultData->TariffPlanInfo->TariffPlanId)/* [
                        'IsGPRS' => $resultData->TariffPlanInfo->IsGPRS,
                        'IsRealIP' => $resultData->TariffPlanInfo->IsRealIP,
                        'IsUnlimited' => $resultData->TariffPlanInfo->IsUnlimited,
                        'TariffPlanDescription' => $resultData->TariffPlanInfo->TariffPlanDescription,
                        'TariffPlanId' => $resultData->TariffPlanInfo->TariffPlanId,
                    ]*/,
                    //additional data
                    'timeout' => time(),
                    'storage_name' => Authentication::getStorageAdapterName(),
                    'access_token' => \helpers\Common::incrementalHash(),
                ];

                if (Authentication::registrSession($dataSession)) {
                    return Authentication::getStorage();
                }
            } else {
                throw new \Exception(\library\Error::APISTATUSCODENOTHANDLEDMESSAGE, $resultData->ResultCode);
            }
        } else {
            throw new \Exception(\library\Error::RECIEVEDDATAFROMAPINOTOBJECTMESSAGE, \library\Error::RECIEVEDDATAFROMAPINOTOBJECTCODE);
        }
    }

    public static function loqout() {

        return Authentication::deleteSession();
    }

    //changePassword
    public static function changePassword($oldPassword, $newPassword) {

        if (!(!!$oldPassword) || !(!!$newPassword)) {
            throw new \Exception(\library\Error::EMPTYPARAMETRMESSAGE, \library\Error::EMPTYPARAMETRCODE);
        }
        if (strlen($oldPassword) < 6 || strlen($newPassword) < 6) {
            throw new \Exception(\library\Error::PASSWORDMESSAGE, \library\Error::PASSWORDCODE);
        }


        $phoneNumber = \models\Authentication::getPropertyFromStorage('phoneNumber');


        $result = \helpers\SoapClientClass::call('changePassword', [
                    'phoneNumber' => $phoneNumber,
                    'oldPassword' => $oldPassword,
                    'newPassword' => $newPassword,
        ]);
        return \helpers\Common::isSuccess($result, 'changePassword');
    }

}
