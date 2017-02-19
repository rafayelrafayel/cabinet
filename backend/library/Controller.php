<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Controller
 *
 * @author Rafayel Khachatryan
 */

namespace library;

class Controller {

    protected $_layout = true;

    public function redirect() {
        
    }

    public function render($view = null, $parametrs = []) {
      
        if (null !== $view) {
            if (strpos($view, '/') === false) {
                $view = \helpers\Common::ROOTNAMESPACE . '/' . \helpers\Common::$ACTIVEMODULE . '/views/' .  $this->getActiveController().'/'. $view . '.php';
            } else {
                $view = $view . '.php';
            }

            if (!empty($parametrs)) {
                foreach ($parametrs as $key => $parametr) {
                    $$key = $parametr;
                }
            }
            require_once $view;
        } else {
            throw new \Exception('View Name is Empty', '404');
        }
    }

    private function getActiveController() {
        $className = get_class($this);
        $arr = explode('\\', $className);
        return strtolower(end($arr));
    }

}
