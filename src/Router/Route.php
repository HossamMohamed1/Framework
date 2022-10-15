<?php

namespace phplite\Router;
use phplite\Http\Request;
use BadFunctionCallException;
use phplite\View\View;

class Route{

    /**Route container */
    private static $routes =[];
    /**Route Midell-ware */
    private static $middleware;
    /**prefix */
    private static $prefix;
    private function __construct()
    {
        
    }
    /**ADD Route */
    private static function add($methods , $uri , $callback)
    {
        $uri = trim($uri , '/');
        $uri = rtrim(static::$prefix . '/' . $uri , '/');
        $uri = $uri?:'/';
        foreach(explode('|',$methods) as $method)
        {
            static::$routes[] = [
                'uri'        => $uri,
                'callback'   => $callback,
                'method'     => $method,
                'middleware' => static::$middleware,
            ];
        }
    }
    /**GET ROUTE FUNCTION*/
    public static function get($uri ,$callback){
        static::add('GET' , $uri , $callback );
    }
    /**POST ROUTE FUNCTION*/
    public static function post($uri ,$callback){
        static::add('POST' , $uri , $callback );
    }
    /**ANY ROUTE FUNCTION*/
    public static function any($uri ,$callback){
        static::add('GET|POST' , $uri , $callback );
    }



    /**Set Prefix For Routing */
    public static function prefix($prefix ,$callback)
    {
        $parent_prefix = static::$prefix;
        /**case having instad prefix */
        static::$prefix .= '/' . trim($prefix , '/');
        if(is_callable($callback))
        {
            call_user_func($callback);
        }
        else{
            throw new \BadFunctionCallException("please provide a valid call back function");
        }

        static::$prefix =$parent_prefix;
    }
    /**Set middleware For Routing */
    public static function middleware($middleware ,$callback)
    {
        $parent_middleware = static::$middleware;
        /**case having instad prefix */
        static::$middleware .= '|' . trim($middleware , '|');
        if(is_callable($callback))
        {
            call_user_func($callback);
        }
        else{
            throw new \BadFunctionCallException("please provide a valid call back function");
        }

        static::$middleware =$parent_middleware;
    }


    /**Handeling request and match routes */
    public static function handle(){
        $uri = Request::url();

        foreach(static::$routes as $route)
        {
            $matched = true;
            $route['uri'] = preg_replace('/\/{(.*?)}/' , '/(.*?)', $route['uri']);
            $route['uri'] = '#^'. $route['uri'] . '$#';
            if(preg_match($route['uri'] , $uri , $matches))
            {
                array_shift($matches);
                $params = array_values($matches);
                foreach( $params as $param )
                {
                    if(strpos($param , '/'))
                    {
                        $matched = false;
                    }
                }
                if( $route['method'] != Request::method()){
                    $matched = false;
                }
                if($matched == true)
                {
                    return static::invoke($route , $params) ;
                }
                
            }
        }
       return View::render('errors.404');
        
    }
    /******invoke Routes */
    public static function invoke($route , $params = [])
    {
        
        if($route['middleware'] !== NULL){
            static::executeMiddleware($route);
        }
        $callback = $route['callback'];
        if(is_callable($callback))
        {
            return call_user_func_array($callback , $params);
        }elseif(strpos($callback ,'@') !== false){
            list($controller ,$method) = explode('@' , $callback);
            $controller = 'App\Controllers\\' . $controller;
            if(class_exists($controller))
            {
                $object = new $controller;
                if(method_exists($object , $method)){
                    return call_user_func_array([$object , $method] , $params);
                }
                else{
                    throw new BadFunctionCallException("the method". $method . "is not Exists at" . $controller);
                }
            }else{
                throw new \ReflectionException("Class " . $controller . " Not Found");
            }
        }else{
            throw new \InvalidArgumentException("please provide valid callback function");
        }
    }

    /**Middleware function */
    public static function executeMiddleware($route)
    {
        foreach(explode('|',$route['middleware']) as $middleware)
        {
            if($middleware != ''){
                $middleware ='App\Middleware\\' . $middleware;
                if(class_exists($middleware))
                {
                    $object = new $middleware;
                     call_user_func_array([$object ,'handle'], []);
                }else{
                    throw new \ReflectionException("Class " . $middleware . " Not Found");
                }
            }
        }
    }
    /**
     * **************************
     * All Routes Test Function *
     * **************************
     *public static function allRoutes(){ return static::$routes; } 
     */
    
}