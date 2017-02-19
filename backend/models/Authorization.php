<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace models;

/**
 * Description of Authorization
 *
 * @author Rafayel Khachatryan
 */
class Authorization {

    private static $HEADERS = null;

    public static function getToken() {
        $headers = self::getRequestHeaders();

        return isset($headers["Access-Token"]) ? $headers["Access-Token"] : null;
    }

    public static function checkToken() {
        $token = self::getToken();
        if (is_null($token) || $token !== \models\Authentication::getPropertyFromStorage('access_token')) {
            throw new \Exception(\library\Error::INVALIDTOKENMESSAGE, \library\Error::INVALIDTOKENCODE);
        }
        return true;
    }

    public static function getRequestHeaders() {
        if (!is_null(self::$HEADERS)) {
            return self::$HEADERS;
        }

        if (!function_exists('apache_request_headers')) {

            function apache_request_headers() {
                $out = array();
                foreach ($_SERVER as $key => $value) {
                    if (substr($key, 0, 5) == "HTTP_") {
                        $key = str_replace(" ", "-", ucwords(strtolower(str_replace("_", " ", substr($key, 5)))));
                        $out[$key] = $value;
                    } else {
                        $out[$key] = $value;
                    }
                }
                return $out;
            }

        }

        self::$HEADERS = apache_request_headers();
        return self::$HEADERS;
    }

}
