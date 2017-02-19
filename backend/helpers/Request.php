<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of class
 *
 * @author Rafayel Khachatryan
 */

namespace helpers;

class Request {

    private static $REQUESTDATA = null;

    public static function post($param = null) {
        $post = [];
        if (!empty($_POST)) {
            foreach ($_POST as $k => $each) {
                $post[$k] = self::check($each);
            }
        }
        if (func_num_args() == 0)
            return $post;

        if (null !== $param && array_key_exists($param, $post)) {
            return $post[$param];
        } else {
            return null;
        }
        return $post;
    }

    public static function get($param = null, $returnDefault = false) {
        $get = [];
        if (!empty($_GET)) {
            foreach ($_GET as $k => $each) {
                $get[$k] = self::check($each);
            }
        }
        if (func_num_args() == 0)
            return $get;
        if (null !== $param && array_key_exists($param, $get)) {
            return $get[$param];
        } elseif (false !== $returnDefault) {
            return $returnDefault;
        } else {
            return null;
        }
        return $get;
    }

    private static function check($param) {

        $param = @strip_tags($param);
        $param = @stripslashes($param);
        $invalid_characters = array("$", "%", "#", "<", ">", "|");
        $param = str_replace($invalid_characters, "", $param);

        return $param;
    }

    public static function removeParams($params = [], $request = []) {
        if (!empty($params)) {
            foreach ($params as $param) {
                if (array_key_exists($param, $request)) {
                    unset($request[$param]);
                }
            }
        }
        return $request;
    }

    public static function getJsonData() {
        if (null === self::$REQUESTDATA) {
            $requestData = \helpers\Json::decode(file_get_contents("php://input"));
            $request = [];
            if (is_object($requestData)) {
                $requestDataArray = (array) $requestData;
                if (!empty($requestDataArray)) {
                    foreach ($requestDataArray as $key => $value) {
                        $request[$key] = self::check($value);
                    }
                }
                /*else {
                    throw new \Exception(\library\Error::EMPTYJSONMESSAGE, \library\Error::EMPTYJSONCODE);
                }*/
            } 
            /*else {
                throw new \Exception(\library\Error::INVALIDJSONMESSAGE, \library\Error::INVALIDJSONCODE);
            }*/
            self::$REQUESTDATA = $request;
        }
        return self::$REQUESTDATA;
    }

    public static function request($param = null) {
        $requestData = self::getJsonData();
        if (null !== $param && array_key_exists($param, $requestData)) {
            return $requestData[$param];
        }
        return '';
    }

}
