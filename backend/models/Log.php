<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace models;

use models\Pdo;

/**
 * Description of Log
 *
 * @author Rafayel Khachatryan
 */
class Log {

    public static function save($data) {
        $sql = "CALL setLog(:p_type,:p_in_out,:p_session,:p_method,:p_file,:p_text,:p_error)";
        $condition['p_type'] = $data['p_type'];
        $condition['p_in_out'] = $data['p_in_out'];
        $condition['p_session'] = $data['p_session'];
        $condition['p_method'] = $data['p_method'];
        $condition['p_file'] = $data['p_file'];
        $condition['p_text'] = $data['p_text'];
        $condition['p_error'] = $data['p_error'];
        Pdo::getInstance()->get()->prepare($sql)->execute($condition);
    }

}
