<?php
namespace phplite\Http;

class Server{
    private function __construct()
    {
        
    }
    /**check if has a key */
    public static function has($key)
    {
        return isset($_SERVER[$key]);
    }
    /**Return value if has */
    public static function get($key)
    {
        $value = null;
        if(static::has($key))
        {
            $value = $_SERVER[$key];
        }
        return $value;
    }
    /**All_SERVER_DATA */
    public static function All()
    {
        return $_SERVER;
    }
    /**Get path info for path  */
    public static function path_info($path)
    {
        return pathinfo($path);
    }
}