<?php
namespace phplite\Session;

class Session{
    private function __construct()
    {
        
    }

    public static function start()
    {
        if(! session_id()){
            ini_set('session.use_only_cookies',1);
            session_start();
        }
        
    }
    /**SET_NEW_SESSION */
    public static function set($key,$value)
    {
        $_SESSION[$key] = $value;
        return $value;
    }
    /**check if there is a key for session */
    public static function has($key)
    {
        return isset($_SESSION[$key]);
    }
    /**Get Session by key */
    public static function get($key)
    {
        return static::has($key)? $_SESSION[$key] : null;
    }
    /**Remove SESSION by key */
    public static function remove($key)
    {
        unset($_SESSION[$key]);
    }

    /**Return ALL SESSIONS */
    public static function all()
    {
        return $_SESSION;
    }
    /**Destroy All */
    public static function destroy()
    {
        foreach(static::all() as $Key => $value)
        {
            static::remove($Key);
        }
    }
    /**Flash Calling and Remove  */
    public static function flash($key)
    {
       /**$value= static::get($key);
        static::remove($key);
        return $value */
        $value = null;
        if(static::has($key)){
            $value = static::get($key);
            static::remove($key);
        } 
        return $value;
    }
}