<?php
namespace phplite\Http;

class Request{

    private static $script_name;
    private static $base_url;
    private static $url;
    private static $full_url;
    private static $query_string;

    private function __construct(){}

    /**Handle Request */
    public static function handle()
    {
        static::$script_name = str_replace('\\','',dirname(Server::get('SCRIPT_NAME')));
        static::setBaseUrl();
        static::setUrl();
    }
    /**setBaseUrl */
    private static function setBaseUrl(){
        $protocol = Server::get('REQUEST_SCHEME').'://';
        $host =Server::get('HTTP_HOST');
        $script_name = static::$script_name;
        static::$base_url = $protocol . $host . $script_name;
    }
    /**setUrl */
    private static function setUrl(){
        $request_uri = urldecode(Server::get('REQUEST_URI'));
        $request_uri = rtrim( preg_replace("#^".static::$script_name."#",'',$request_uri)  ,'/');
        
        $query_string = '';

        static::$full_url = $request_uri;
        if(strpos($request_uri , '?') !== false)
        {
            list($request_uri , $query_string) = explode('?' , $request_uri);
        }

        static::$url = $request_uri?:'/';
        static::$query_string = $query_string;
    }

    /**Get BaseUrl */
    public static function baseUrl()
    {
        return static::$base_url;
    }
     /**Get Url */
     public static function url()
     {
         return static::$url;
     }
      /**Get QueryString */
    public static function queryString()
    {
        return static::$query_string;
    }
    /**Get FullUrl */
    public static function fullUrl()
    {
        return static::$full_url;
    }

    /**Get Request Method */
    public static function method()
    {
        return Server::get('REQUEST_METHOD');
    }
    /**check that the request has the key */
    public static function has($type , $key)
    {
       return array_key_exists($key , $type);
    }
    /**Get value from Request */
    public static function value($key , array $type = null )
    {
        $type = isset($type) ? $type : $_REQUEST;
        return static::has($type ,$key) ? $type[$key] : null;
    }
    /**Get value from GET Request */
    public static function get($key)
    {
        return  static::value($key ,$_GET) ;
    }
    /**All Data */
    public static function allGetData()
    {
        return $_GET;
    }
     /**Get value from POST Request */
     public static function post($key)
     {
        return  static::value($key ,$_POST) ;
     }
     /**All Data */
     public static function allPostData()
     {
         return $_POST;
     }
     /**Set value to the request by the given key  */
     public static function set($key , $value)
     {
        $_REQUEST[$key] = $value;
        $_GET[$key] = $value;
        $_POST[$key] = $value;

        return $value;

     }
     /**previous بتظهرلك الصفحه اللي قبل الحالية : اللي انت جاي منها */
     public static function previous(){
        return Server::get('HTTP_REFERER');
     }
     /**All Request */
     public static function all()
     {
         return $_REQUEST;
     }
}