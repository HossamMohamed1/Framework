<?php
namespace phplite\Url;
use phplite\Http\Request;
use phplite\Http\Server;

class Url{
    private function __construct()
    {
        
    }
    /**http://phplite.test/users/1/edit
     * 
     * Get Path
     */
    public static function path($path)
    {
        return Request::baseUrl() . '/' . trim($path , '/');
    }
    /**previous url 
     * ***********Deprecated function****************
    */
    public static function previous()
    {
        return Server::get('HTTP_REFERER');
    }
    /**Redirect function  */
    public static function redirect($path){
        header('location: '. $path);
        exit();
    }
}