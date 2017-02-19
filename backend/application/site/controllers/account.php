<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace application\site\controllers;

/**
 * Description of account
 *
 * @author Rafayel Khachatryan
 */
class account extends \library\Controller {

    public function index() {
        \models\AccountManagement::getNewDayParam();
    }

    public function addnewday() {
        \models\Authorization::checkToken();

        $amount = (int) \helpers\Request::request('amount');

        return \helpers\Common::returnResultOrError(\models\AccountManagement::addNewDay($amount));
    }

    public function getnewdayparam() {
        \models\Authorization::checkToken();
        return \models\AccountManagement::getNewDayParam();
    }

    public function tranfermoney() {
        \models\Authorization::checkToken();
        $amount = \helpers\Request::request('amount');
        $recipientPhoneNumber = \helpers\Common::getPhoneNumberForApi(\helpers\Request::request('recipientPhoneNumber'));
        return \helpers\Common::returnResultOrError(\models\AccountManagement::transferAmount($recipientPhoneNumber, $amount));
    }

}
