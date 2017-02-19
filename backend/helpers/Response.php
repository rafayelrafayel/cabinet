<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Response
 *
 * @author Rafayel Khachatryan
 */

namespace helpers;

class Response {

    public static function generateResponse($data) {
        return array_merge(array("error_code" => 0, "error_message" => ""), (array) $data);
    }

}
