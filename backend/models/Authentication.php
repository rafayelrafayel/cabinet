<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Authentication
 *
 * @author Rafayel Khachatryan
 */

namespace models;

class Authentication {

    private static $STORAGENAME = 'cabinet';
    private static $STORAGEADAPTERNAME = 'session';
    private static $STORAGE = [];

    public static function setStorageName($name = NULL) {
        if (!is_null($name)) {
            self::$STORAGENAME = $name;
        }
    }

    public static function getStorageName() {
        return self::$STORAGENAME;
    }

    public static function getStorageAdapterName() {
        return self::$STORAGEADAPTERNAME;
    }

    public static function setStorageAdapter($use_cookie = FALSE) {
        if (FALSE === $use_cookie) {
            self::$STORAGE = $_SESSION;
        } else {
            self::$STORAGE = $_COOKIE;
            self::$STORAGEADAPTERNAME = 'cookie';
        }
    }

    public static function getStorageAdapter() {

        if (isset($_SESSION[self::$STORAGENAME])) {
            self::$STORAGE = $_SESSION;
            return true;
        }
        if (isset($_COOKIE[self::$STORAGENAME])) {
            self::$STORAGE = $_COOKIE;
            return true;
        }
        return false;
    }

    public static function registrSession($dataSession = array(), $use_cookie = FALSE) {

        if (FALSE !== $use_cookie) {
            self::setStorageAdapter(TRUE);
        }
        if (!empty($dataSession)) {
            if (isset(self::$STORAGE[self::$STORAGENAME])) {
                self::deleteSession();
            } else {


                self::$STORAGE[self::$STORAGENAME] = serialize($dataSession);

                if (FALSE === $use_cookie) {
                    if (self::checkSession() === FALSE) {
                        $_SESSION[self::$STORAGENAME] = self::$STORAGE[self::$STORAGENAME];
                    }
                    return TRUE;
                } else {

                    if (self::checkSession() === FALSE) {
                        setcookie(self::$STORAGENAME, self::$STORAGE[self::$STORAGE], time() + 60 * 60 * 24 * 30, '/', NULL, FALSE, TRUE);
                    }
                    return TRUE;
                }
            }
        }
        return FALSE;
    }

    public static function checkSession() {
        $bool = self::getStorageAdapter();
        if ($bool) {
            if (isset(self::$STORAGE[self::$STORAGENAME])) {
                return TRUE;
            }
        }

        return FALSE;
    }

    public static function deleteSession($storageName = '') {
        if (!empty($storageName)) {
            self::$STORAGENAME = $storageName;
        }
        $bool = self::getStorageAdapter();
        if ($bool) {
            if (isset($_SESSION[self::$STORAGENAME])) {
                unset($_SESSION[self::$STORAGENAME]);
                return TRUE;
            }
            if (isset($_COOKIE[self::$STORAGENAME])) {
                unset($_COOKIE[self::$STORAGENAME]);
                setcookie(self::$STORAGENAME, '', time() - 3600, '/', NULL, FALSE, TRUE);

                return TRUE;
            }
        }
        return FALSE;
    }

    public static function getStorage($storageName = '') {
        if (!empty($storageName)) {
            if (array_key_exists($storageName, self::$STORAGE)) {
                self::$STORAGENAME = $storageName;
            }
        }
        $bool = self::getStorageAdapter();

        if (TRUE === $bool) {
            return unserialize(self::$STORAGE[self::$STORAGENAME]);
        }
        return FALSE;
    }

    public static function getPropertyFromStorage($name = '') {

        $storage = self::getStorage();
        if (false !== $storage && array_key_exists($name, $storage)) {
            return $storage[$name];
        }
        return null;
    }

    public static function setStorage($data = array(), $storageName = '') {
        if (!empty($storageName)) {
            self::$STORAGENAME = $storageName;
        }

        $bool = self::getStorageAdapter();
        if (TRUE === $bool) {
            $storage = unserialize(self::$STORAGE[self::$STORAGENAME]);
            if (!empty($data)) {
                foreach ($data as $key => $value) {
                    if (array_key_exists($key, $storage)) {
                        $storage[$key] = $data[$key];

                        self::$STORAGE[self::$STORAGENAME] = serialize($storage);
                        if ($storage['storage_name'] == 'cookie') {
                            setcookie(self::$STORAGENAME, self::$STORAGE[self::$STORAGENAME], time() + 60 * 60 * 24 * 30, '/', NULL, FALSE, TRUE);
                        } else {
                            $_SESSION[self::$STORAGENAME] = self::$STORAGE[self::$STORAGENAME];
                        }
                    }
                }
            }
        }
    }

}
