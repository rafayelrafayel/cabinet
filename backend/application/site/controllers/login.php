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

class login extends \library\Controller {

    public function index() {



        return \models\User::login(\helpers\Request::getJsonData());
    }

    public function logout() {
        \models\Authorization::checkToken();
        if (\models\User::loqout()) {
            return [];
        } else {
            throw new \Exception(\library\Error::LOGOUTFAILED, \library\Error::LOGOUTFAILEDCODE);
        }
    }

    public function changepassword() {
        \models\Authorization::checkToken();
        $oldPassword = \helpers\Request::request('oldPassword');
        $newPassword = \helpers\Request::request('newPassword');
        
       
        if (\models\User::changePassword($oldPassword, $newPassword)) {
            return [];
        } else {
            throw new \Exception(\library\Error::OPERATIONFAILEDMESSAGE, \library\Error::OPERATIONFAILEDCODE);
        }
    }

}
