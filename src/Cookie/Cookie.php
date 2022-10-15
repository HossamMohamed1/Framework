<?php
namespace phplite\Cookie;

class Cookie{
    private function __construct()
    {
        
    }


    /**SET_NEW_COOKIE */
    public static function set($key,$value)
    {
        $expired = time() + (1*365*24*60*60);
       setcookie($key,$value,$expired , '/' , '' , false , true);
        return $value;
    }
    /**check if there is a key for cookie */
    public static function has($key)
    {
        return isset($_COOKIE[$key]);
    }
    /**Get Cookie by key */
    public static function get($key)
    {
        return static::has($key)? $_COOKIE[$key] : null;
    }
    /**Remove Cookie by key */
    public static function remove($key)
    {
        unset($_COOKIE[$key]);
       // setcookie($key , null , -1 , '/');
    }

    /**Return ALL COOKIE */
    public static function all()
    {
        return $_COOKIE;
    }
    /**Destroy All */
    public static function destroy()
    {
        foreach(static::all() as $Key => $value)
        {
            static::remove($Key);
        }
    }
    
}