<?php

/**
 * View rendr
 */
if(! function_exists('view')){
    function view($path , $data = [])
    {
        return \phplite\View\View::render($path , $data);
    }
}

/**
 * Request Get
 */
if(! function_exists('request')){
    function request($key)
    {
        return \phplite\Http\Request::value($key);
    }
}

/**
 * Redirect 
 */
if(! function_exists('redirect')){
    function redirect($path)
    {
        return \phplite\Url\Url::redirect($path);
    }
}

/**
 * previous
 */
if(! function_exists('previous')){
    function previous()
    {
        return \phplite\Url\Url::previous();
    }
}
/**
 * url
 */
if(! function_exists('url')){
    function url($path)
    {
        return \phplite\Url\Url::path($path);
    }
}

/**
 * Asset
 */
if(! function_exists('asset')){
    function asset($path)
    {
        return \phplite\Url\Url::path($path);
    }
}

/**
 * Dump and Die
 */
if(! function_exists('dd')){
    function dd($data)
    {
        echo "<pre>";
        if(is_string($data))
        {
            echo $data;
        }else{
            print_r($data);
        }
        echo "</pre>";
        die();
    }
}

/**
 * Get session data
 */
if(! function_exists('session')){
    function session($key)
    {
        return \phplite\Session\Session::get($key);
    }
}

/**
 *flas data
 */
if(! function_exists('flas')){
    function flash($key)
    {
        return \phplite\Session\Session::flash($key);
    }
}

/**
 *Show pagination links
 */
if(! function_exists('links')){
    function links($current_page , $pages)
    {
        return \phplite\Database\Database::links($current_page , $pages);
    }
}

/**
 * Table auth
 */
if(! function_exists('auth')){
    function auth($table)
    {
        $auth = phplite\Session\Session::get($table) ?: phplite\Cookie\Cookie::get($table);
        return \phplite\Database\Database::table($table)->where('id','=',$auth)->first();
    }
}

