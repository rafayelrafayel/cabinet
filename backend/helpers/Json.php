<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Json
 *
 * @author Rafayel Khachatryan
 */

namespace helpers;

class Json {

    public static function encode($data = []) {
        return json_encode($data, JSON_UNESCAPED_SLASHES);
    }

    public static function decode($json = []) {
        return json_decode($json);
    }

    public static function encondeAndResponse($data) {
        header('Content-Type: application/json');
        echo self::encode($data);
        exit;
    }

}
