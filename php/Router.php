<?php

namespace php;

require_once 'MainFunc.php';
class Router
{


    /**
     * @param $url
     * @return bool|mixed
     */
    public static function dispatch($url){
        $route = explode('/',trim($url, '/'));
        if ($route[0] == 'index.php'){
            $route[2] = 'get_users';
        }
        $controller = \MainFunc::class;
        if(class_exists($controller)){
            $controllerObj = new $controller();
            $action = lcfirst(self::toUpperCamelCase($route[2]));
            if (method_exists($controllerObj, $action)){
            return $controllerObj->$action();
            }
        }
        return false;
    }

    /**
     * @param $str
     * @return string
     */
    public static function toUpperCamelCase($str){
        $str = str_replace(' ','',ucwords(str_replace(['-','_'],' ', $str)));
        return $str;
    }

}