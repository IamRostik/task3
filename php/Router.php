<?php

namespace php;
use Main_func;

require_once 'Main_func.php';
class Router
{


    /**
     * @param $url
     * @return bool|mixed
     */
    public static function dispatch($url){
        $route = explode('/',trim($url, '/'));
        $controller = Main_func::class;
        if(class_exists($controller)){
            $controllerObj = new $controller();
            if (!isset($route[2])) {
                return $controllerObj->getUsers();
            } else {
                $action = self::toCamelCase($route[2]);
            }
            if (method_exists($controllerObj, $action)){
            $controllerObj->$action();
            return true;
            }
        }
        return false;
    }

    /**
     * @param $str
     * @return string
     */
    public static function toCamelCase($str){
        $str = ucwords(str_replace(['-','_'],' ', $str));
        $str = lcfirst(str_replace(' ','', $str));
        return $str;
    }

}