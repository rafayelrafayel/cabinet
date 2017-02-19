<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace application\site\controllers;

/**
 * Description of bonus
 *
 * @author Rafayel Khachatryan
 */
class bonus {

    public function index() {
        //  echo '<pre>';       print_r(\models\Bonus::getMTSBonusList());  echo '</pre>';
        //  return \models\Bonus::getMTSBonusList();
    }

    public function getmtsbonuslist() {

        \models\Authorization::checkToken();
        return \models\Bonus::getMTSBonusList();
    }

    public function getmtsbonuspoints() {
        \models\Authorization::checkToken();
        return \models\Bonus::getMTSBonusPoints();
    }

    public function convertmtsbonuspoints() {
        \models\Authorization::checkToken();
        $prizeId = \helpers\Request::request('PrizeId');

        return \helpers\Common::returnResultOrError(\models\Bonus::convertMTSBonusPoints($prizeId));
    }

    public function getmtsactivebonuslist() {
        \models\Authorization::checkToken();
        return \models\Bonus::getMTSActiveBonusList();
    }

    public function getmtsbonushistory() {
        \models\Authorization::checkToken();
        $from = \helpers\Common::createDateTime(\helpers\Request::request('from'));
        $to = \helpers\Common::createDateTime(\helpers\Request::request('to'));


        if ($from >= $to) {
            throw new \Exception(\library\Error::FROMTODATEERRORMESSAGE, \library\Error::FROMTODATEERRORMCODE);
        }
        return \models\Bonus::getMTSBonusHistory($from, $to);
    }

    public function handledetailedbill() {
        \models\Authorization::checkToken();
        $from = \helpers\Common::createDateTime(\helpers\Request::request('from')); //'2015-01-01T15:03:01';//
        $to = \helpers\Common::createDateTime(\helpers\Request::request('to')); //'2016-01-01T15:03:01';//
        $email = \helpers\Request::request('email'); // 'rafokhach@gmail.com';
        $langId = 1;
        
//        var_dump($email);
//        var_dump($from);
//        var_dump($to);
//        var_dump($langId);
//        die;
   
        if ($from >= $to) {
            throw new \Exception(\library\Error::FROMTODATEERRORMESSAGE, \library\Error::FROMTODATEERRORMCODE);
        }
        return \helpers\Common::returnResultOrError(\models\Bonus::getDetailedBill($email, $from, $to, $langId));
    }

}
