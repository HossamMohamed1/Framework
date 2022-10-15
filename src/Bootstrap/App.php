<?php
namespace phplite\Bootstrap;

use phplite\Cookie\Cookie;
use phplite\Exceptions\Whoops;
use phplite\Http\Request;
use phplite\Http\Server;
use phplite\Session\Session;
use phplite\File\File;
use phplite\Http\Response;
use phplite\Router\Route;
class App{
    private function __construct(){}

    public static function run(){
        /**Register Whoops */
        Whoops::handle();

        /**SeSSION_START() */
        Session::start();
        /**************************************************************************************************************
         *     echo Server::has('test');
               Server::has('SERVER_ADDR')
               echo "<pre>";
               print_r(Server::All());
               echo "</pre>";
               echo "<pre>";
               print_r(Server::path_info('http://phplite.test/'));
               echo "</pre>";
               ******All Routes*******
               echo "<pre>";
               print_r(Route::allRoutes());
               echo "</pre>";
        **************************************************************************************************************/
     

        /**Request Handeling */
        Request::handle();
        /**Require all routes Directory */
        File::require_directory('routes');
        /**Handling Route */
        $data = Route::handle();

        Response::output($data);

    }
   
}