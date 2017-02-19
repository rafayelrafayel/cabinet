<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * class working with Routes
 *
 * @author Rafayel Khachatryan
 */

namespace library;

class Application {

    protected $_module = '';
    protected $_lang = '';
    protected $_controller = '';
    protected $_action = '';
    protected $_params = array();
    protected $_passedparams = array();

    //protected $_returningroute = '';

    private function filterUrl($url) {
        $url = strip_tags($url);
        $url = strtolower($url);
        $url = rtrim($url, '/');
        $url = preg_replace('~[^a-z0-9-@. \/ \x80-\xFF]~i', "", $url);
        return $url;
    }

    /*     * *
     * get whole route
     */

    public function __construct() {

        $this->check_for_options();

        $route = \helpers\Request::get('route');

        if ('' == $route) {

            $route = 'index';
            $this->_module = DEFAULT_MODULE;
            $this->_lang = DEFAULT_LANGUAGE;
            $this->_controller = 'index';
            $this->_action = 'index';
        } else {
            $route = $this->filterUrl($route);
            $route = ltrim($route, '/');
            $arrayroute = explode('/', $route);

            if (in_array($arrayroute['0'], unserialize(MODULES)) && (string) $arrayroute['0'] !== (string) DEFAULT_MODULE) {


                $this->_module = $arrayroute['0'];



                if (isset($arrayroute['1']) && strlen($arrayroute['1']) == 2) {
                    $this->_lang = $arrayroute['1'];
                } else {
                    $this->_lang = DEFAULT_LANGUAGE;

                    if (isset($arrayroute['1'])) {
                        $this->_controller = $arrayroute['1'];
                    } else {
                        $this->_controller = 'index';
                    }


                    if (isset($arrayroute['2'])) {
                        $this->_action = $arrayroute['2'];
                    } else {
                        $this->_action = 'index';
                    }
                    unset($arrayroute['0']);
                    unset($arrayroute['1']);
                    unset($arrayroute['2']);

                    $this->_passedparams = $arrayroute;
                    return TRUE;
                }
                if (isset($arrayroute['2'])) {
                    $this->_controller = $arrayroute['2'];
                } else {
                    $this->_controller = 'index';
                }
                if (isset($arrayroute['3'])) {
                    $this->_action = $arrayroute['3'];
                } else {
                    $this->_action = 'index';
                }
                unset($arrayroute['0']);
                unset($arrayroute['1']);
                unset($arrayroute['2']);
                unset($arrayroute['3']);

                $this->_passedparams = $arrayroute;
            } else {

                $this->_module = DEFAULT_MODULE;

                if (strlen($arrayroute['0']) == 2) {
                    $this->_lang = $arrayroute['0'];
                } else {
                    $this->_lang = DEFAULT_LANGUAGE;
                    array_unshift($arrayroute, $this->_lang);
                }


                if (isset($arrayroute['1'])) {
                    $this->_controller = $arrayroute['1'];
                } else {
                    $this->_controller = 'index';
                }
                if (isset($arrayroute['2'])) {
                    $this->_action = $arrayroute['2'];
                } else {
                    $this->_action = 'index';
                }


                if (count($arrayroute) > 2) {
                    unset($arrayroute['0']);
                    unset($arrayroute['1']);
                    unset($arrayroute['2']);

                    $this->_passedparams = $arrayroute;
                }
            }
        }
    }

    /**
     * 
     * @return string controller
     */
    private function getController() {

        $path_to_controller = \helpers\Common::ROOTNAMESPACE . '/' . $this->_module . '/controllers/' . $this->_controller . '.php';

        if (!file_exists($path_to_controller)) {
            $this->setErrorController();
            $path_to_controller = \helpers\Common::ROOTNAMESPACE . '/' . $this->_module . '/controllers/' . $this->_controller . '.php';
        }
        return $path_to_controller;
    }

    private function getClassName($pathName = null) {
        if (null !== $pathName) {
            $cl = explode('.', $pathName);
            $cl = $cl[0];
            $cl = '\\' . str_replace("/", "\\", $cl);
            return $cl;
        }
        return null;
    }

    public function getAction() {

        return $this->_action;
    }

    public function setAction($action) {
        $this->_action = $action;
    }

    public function getActionasMethod() {
        $action = $this->_action;
        return $action . '()';
    }

    public function getLang() {
        return $this->_lang;
    }

    public function getControllerName() {
        return $this->_controller;
    }

    public function setErrorController() {
        $this->_controller = 'error';
        $this->_action = 'index';
    }

    /**
     * get module name
     * @return string
     */
    public function getModuleName() {
        return $this->_module;
    }

    /**
     * get passing params
     * @return array
     */
    public function getParams() {
        return $this->_passedparams;
    }

    /**
     * get all request parametrs
     */
    public function getRequestParametrs() {
        return array(
            'module' => $this->_module,
            'lang' => $this->_lang,
            'controller' => $this->_controller,
            'action' => $this->_action,
        );
    }

    /**
     * get view
     * @return string 
     */
    public function getView() {

        $view_file = $this->_controller . '/' . $this->_action . '.php';

        /* for skin */
        $path_view_skin = 'skins/' . HTTP_ROOT_ALIAS . '/modules/' . $this->_module . '/views/';
        $view_skin = $path_view_skin . $view_file;

        if (file_exists($view_skin)) {
            return $view_skin;
        } else {
            $folderName = 'views';
            if (!!IS_MOBILE)
                $folderName = 'viewsmobile';

            $path_view = 'application/' . $this->_module . '/' . $folderName . '/';
            $view = $path_view . $view_file;

            if (file_exists($view)) {

                return $view;
            } else {

                $route = 'error';
                $view = $path_view_skin . $route . '.php';
                if (!file_exists($view)) {
                    $view = $path_view . $route . '.php';
                }
                if (file_exists($view))
                    return $view;
            }
        }


        /* end for skin */
    }

    /**
     * run the process 
     * @return type 
     */
    public function Run() {

        $controller = $this->getController();



        if (file_exists($controller)) {
            $controllerClassname = $this->getClassName($controller);






            if (!class_exists($controllerClassname, false)) {// prevent double include
                include $controller;
            }

            $contr = new $controllerClassname ();
            \helpers\Common::$ACTIVEMODULE = $this->_module;

            try {
               // $requestData = \helpers\Request::getJsonData();
              
              

                \models\Log::save([
                    'p_type' => 'terminal',
                    'p_in_out' => 'input',
                    'p_session' => \models\Authentication::getPropertyFromStorage('access_token'),
                    'p_method' => $this->_action,
                    'p_file' => realpath($controller),
                    'p_text' => \helpers\Json::encode(\helpers\Common::cleanPassword(\helpers\Request::getJsonData())),
                    'p_error' => 0
                ]);
                // turn on controller action
                if (method_exists($contr, $this->_action)) {
                    if ($this->_controller !== 'error') {
                        $result = call_user_func_array(array($contr, $this->_action), $this->_passedparams);
                        \models\Log::save([
                            'p_type' => 'terminal',
                            'p_in_out' => 'output',
                            'p_session' => \models\Authentication::getPropertyFromStorage('access_token'),
                            'p_method' => $this->_action,
                            'p_file' => realpath($controller),
                            'p_text' => \helpers\Json::encode(\helpers\Common::cleanPassword(\helpers\Response::generateResponse($result))),
                            'p_error' => 0
                        ]);

                        \helpers\Json::encondeAndResponse(\helpers\Response::generateResponse($result));
                    }
                } else {
                    die('Invalid action passed');
                }
            } catch (\Exception $exc) {
                \models\Log::save([
                    'p_type' => 'terminal',
                    'p_in_out' => 'output',
                    'p_session' => \models\Authentication::getPropertyFromStorage('access_token'),
                    'p_method' => $this->_action,
                    'p_file' => realpath($controller),
                    'p_text' => \helpers\Json::encode(array("error_code" => $exc->getCode(), "error_message" => $exc->getMessage())),
                    'p_error' => 1
                ]);
                \helpers\Json::encondeAndResponse(array("error_code" => $exc->getCode(), "error_message" => $exc->getMessage()));
            }



//            // turn on controller action
//            if (method_exists($contr, $this->_action)) {
//                if ($this->_controller !== 'error') {
//                    $result = call_user_func_array(array($contr, $this->_action), $this->_passedparams);
//
//                    \helpers\Json::encondeAndResponse(\helpers\Response::generateResponse($result));
//                }
//            } else {
//                die('Invalid action passed');
//            }
        }
    }

    public function Url($params = array(), $reset = TRUE) {


        $url = '/'; //URL
        if (FALSE === $reset) {
            if (count($params) > 0) {

                $requestParams = $this->getRequestParametrs();

                if (count($requestParams) > 0) {
                    foreach ($requestParams as $key => $request) {
                        if (array_key_exists($key, $params)) {
                            $requestParams[$key] = $params[$key];
                        }
                    }

                    foreach ($requestParams as $key => $request) {
                        if ($key == 'module' && DEFAULT_MODULE === (string) $request)
                            continue;
                        if ($key == 'controller' && 'index' === (string) $request)
                            continue;
                        if ($key == 'action' && 'index' === (string) $request)
                            continue;
                        $url.=$request . '/';
                    }
                    $url.=implode('/', $this->_passedparams);
                }
            }
            return $url;
        }


        if (count($params) > 0) {
            $i = 1;

            foreach ($params as $key => $param) {
                if (count($params) == $i) {
                    $url.=$param;
                } else {
                    $url.=$param . '/';
                }



                $i++;
            }
        }



        return $url;
    }

    public function renderHeader($_disableTemplate = 0) {
        $headerFileName = 'header' . IS_MOBILE . '.php';
        /* render header template */
        if ($_disableTemplate == 0) {
            if (file_exists('skins/' . HTTP_ROOT_ALIAS . '/template/' . $this->_module . '/' . $headerFileName)) {
                return 'skins/' . HTTP_ROOT_ALIAS . '/template/' . $this->_module . '/' . $headerFileName;
            } else {
                return 'template/' . $this->_module . '/' . $headerFileName;
            }
        }
        /* end */
    }

    public function renderFooter($_disableTemplate = 0) {
        $footerFileName = 'footer' . IS_MOBILE . '.php';
        /* render footer template */
        if ($_disableTemplate == 0) {
            if (file_exists('skins/' . HTTP_ROOT_ALIAS . '/template/' . $this->_module . '/' . $footerFileName)) {
                return 'skins/' . HTTP_ROOT_ALIAS . '/template/' . $this->_module . '/' . $footerFileName;
            } else {
                return 'template/' . $this->_module . '/' . $footerFileName;
            }
        }




        /* end */
    }

    public function useCookies() {

        $lang = $this->_lang;
        setcookie('lang', serialize($lang), time() + 60 * 60 * 24 * 30, '/', NULL, FALSE, TRUE);
    }

    public function get_protocol() {
        if (isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) || isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')
            return $protocol = 'https://';
        else
            return $protocol = 'http://';
    }

    public function cors_headers($from_options = false) {
        $origin = '';

        if ($from_options) {
            $allowedUrls = Lib_Pm::getSkinOption("allowed_urls");
            $allowedUrls = implode(" ", $allowedUrls);

            $origin = $allowedUrls;
        }
        if (!$origin) {
            if (!false) {
                if (isset($_SERVER['HTTP_X_FORWARDED_HOST']) && !empty($_SERVER['HTTP_X_FORWARDED_HOST'])) {
                    $origin = $_SERVER['HTTP_X_FORWARDED_HOST'];
                } else {
                    $origin = $_SERVER['HTTP_ORIGIN'];
                }
            } else {
                $origin = $this->get_protocol() . $_SERVER['HTTP_HOST'];
            }
        }
        header('Access-Control-Allow-Origin: ' . $origin);
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Allow-Headers:  *,X-Requested-With,Content-Type');
        header('Access-Control-Allow-Methods: POST, OPTIONS');
        //header('Access-Control-Max-Age: 86400');
    }

    private function check_for_options() {
        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']) && ($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'] == 'POST')) {
                // check for CORS requests
                $this->cors_headers();
            }
            die;
        }
    }

}
