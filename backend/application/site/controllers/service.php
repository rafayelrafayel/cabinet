<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of index
 *
 * @author Rafayel Khachatryan
 */

namespace application\site\controllers;

class service extends \library\Controller {

    public function index() {
        // getNewDayParam
        //  var_dump(\models\ServiceManagement::suspendAccount());
        // var_dump(\models\ServiceManagement::isBlockedService());
        // print_r(\models\Authentication::getStorage());die;
        // \models\ServiceManagement::checkAccount();
    }

    public function addtofavoritelist() {
        \models\Authorization::checkToken();
        $requestData = \helpers\Request::getJsonData();
        if (is_array($requestData) && array_key_exists('phoneNumber', $requestData)) {
            $favoriteNumber = \helpers\Common::getPhoneNumberForApi($requestData['phoneNumber']);
        } else {
            throw new \Exception(\library\Error::PHONENUMBERMISSINGMESSAGE, \library\Error::PHONENUMBERMISSING);
        }
        return \helpers\Common::returnResultOrError(\models\ServiceManagement::addToFavoriteList($favoriteNumber));
    }

    public function addtoblocklist() {
        \models\Authorization::checkToken();
        $requestData = \helpers\Request::getJsonData();

        if (is_array($requestData) && array_key_exists('phoneNumber', $requestData)) {
            $xNumber = \helpers\Common::getPhoneNumberForApi($requestData['phoneNumber']);
        } else {
            throw new \Exception(\library\Error::PHONENUMBERMISSINGMESSAGE, \library\Error::PHONENUMBERMISSING);
        }

        return \helpers\Common::returnResultOrError(\models\ServiceManagement::addToBlockList($xNumber));
    }

    public function addtowhitelist() {
        \models\Authorization::checkToken();
        $requestData = \helpers\Request::getJsonData();
        if (is_array($requestData) && array_key_exists('phoneNumber', $requestData)) {
            $xNumber = \helpers\Common::getPhoneNumberForApi($requestData['phoneNumber']);
        } else {
            throw new \Exception(\library\Error::PHONENUMBERMISSINGMESSAGE, \library\Error::PHONENUMBERMISSING);
        }
        return \helpers\Common::returnResultOrError(\models\ServiceManagement::unBlockFromList($xNumber));
    }

    public function getnumberslist() {
        \models\Authorization::checkToken();
        $requestData = \helpers\Request::getJsonData();
        if (is_array($requestData) && array_key_exists('requestedList', $requestData)) {
            $requestedList = $requestData['requestedList'];
        } else {
            throw new \Exception(\library\Error::EMPTYPARAMETRMESSAGE, \library\Error::EMPTYPARAMETRCODE);
        }
        return \models\ServiceManagement::getNumbersList($requestedList);
    }

    public function unblockfromlist() {
        \models\Authorization::checkToken();
        $requestData = \helpers\Request::getJsonData();

        //  var_dump($requestData);die;

        if (is_array($requestData) && array_key_exists('phoneNumber', $requestData)) {
            $xNumber = \helpers\Common::getPhoneNumberForApi($requestData['phoneNumber']);
        } else {
            throw new \Exception(\library\Error::PHONENUMBERMISSINGMESSAGE, \library\Error::PHONENUMBERMISSING);
        }

        return \helpers\Common::returnResultOrError(\models\ServiceManagement::unBlockFromList($xNumber));
    }

    public function replacenumberinlist() {
        \models\Authorization::checkToken();
        $requestData = \helpers\Request::getJsonData();
        if (!isset($requestData['newNumber']) || !isset($requestData['oldNumber']) || !isset($requestData['callList'])) {
            throw new \Exception(\library\Error::PHONENUMBERMISSINGMESSAGE, \library\Error::PHONENUMBERMISSING);
        } else {
            $newNumber = \helpers\Common::getPhoneNumberForApi($requestData['newNumber']);
            $oldNumber = \helpers\Common::getPhoneNumberForApi($requestData['oldNumber']);
            $callList = $requestData['callList'];
            return \helpers\Common::returnResultOrError(\models\ServiceManagement::replaceNumberInList($newNumber, $oldNumber, $callList));
        }
    }

    public function blockall() {
        \models\Authorization::checkToken();
        return \helpers\Common::returnResultOrError(\models\ServiceManagement::bloackAll());
    }

    public function unblockall() {
        \models\Authorization::checkToken();
        return \helpers\Common::returnResultOrError(\models\ServiceManagement::unBlockAll());
    }

    public function isblockedforall() {
        \models\Authorization::checkToken();
        return \helpers\Common::returnResultOrError(\models\ServiceManagement::isBlockedService());
    }

    public function forward() {
        \models\Authorization::checkToken();
        $cfu = \helpers\Common::getPhoneNumberForApi(\helpers\Request::request('CfuNumber'));
        $cfb = \helpers\Common::getPhoneNumberForApi(\helpers\Request::request('CfbNumber'));
        $cfnrc = \helpers\Common::getPhoneNumberForApi(\helpers\Request::request('CfnrcNumber'));
        $cfnry = \helpers\Common::getPhoneNumberForApi(\helpers\Request::request('CfnryNumber'));
        $nrytime = \helpers\Request::request('CfnrtTime');
        return \helpers\Common::returnResultOrError(\models\ServiceManagement::forward($cfu, $cfb, $cfnrc, $cfnry, $nrytime));
    }

    public function cancelforward() {
        \models\Authorization::checkToken();
        $type = \helpers\Request::request('type');
        return \helpers\Common::returnResultOrError(\models\ServiceManagement::cancelForward($type));
    }

    public function getcallforwardinfo() {
        return \models\ServiceManagement::getCallForwardInfo();
    }

}
