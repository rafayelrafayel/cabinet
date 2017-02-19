<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Common
 *
 * @author Rafayel Khachatryan
 */

namespace helpers;

class Common {

    const ROOTNAMESPACE = 'application';

    public static $ACTIVEMODULE = DEFAULT_MODULE;

    public static function incrementalHash($length = 25) {
        $string = '';
        $characters = "23456789ABCDEFHJKLMNPRTVWXYZabcdefghijklmnopqrstuvwxyz";

        for ($p = 0; $p < $length; $p++) {
            $string .= $characters[mt_rand(0, strlen($characters) - 1)];
        }

        return $string;
    }

    public static function isSuccess($object, $method) {
        if (!is_object($object) || $object->{$method . 'Result'} != '0') {
            throw new \Exception('Api error', $object->{$method . 'Result'});
        }
        return true;
    }

    public static function isSuccessFromObject($object, $method, $output = 'boolean') {
        if (!is_object($object) || !is_object($object->{$method . 'Result'}) || $object->{$method . 'Result'}->ResultCode != '0') {
            throw new \Exception('Api error', $object->{$method . 'Result'}->ResultCode);
        }
        if ($output == 'boolean') {
            return true;
        }
        if ($output == 'object') {
            return $object->{$method . 'Result'};
        }
    }

    public static function getPhoneNumberForApi($number) {
        if (substr($number, 0, 1) != '0') {
            return '0' . $number;
        }
        return $number;
    }

    public static function returnResultOrError($boolean) {
        if ($boolean) {
            return [];
        } else {
            throw new \Exception(\library\Error::OPERATIONFAILEDMESSAGE, \library\Error::OPERATIONFAILEDCODE);
        }
    }

    public static function createDateTime($string) {
        return \DateTime::createFromFormat('d/m/Y', $string)->format(\DateTime::ATOM);
        ;
    }

    public static function cleanPassword($data) {
        foreach ($data as $key => $each)
            if (strpos($key, 'password') !== false)
                unset($data[$key]);
        return $data;
    }

}
