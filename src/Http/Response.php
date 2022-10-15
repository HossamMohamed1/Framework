<?php

namespace phplite\Http;

class Response{
    private  function __construct()
    {
        
    }
     /**json function */
     public static function json($data)
     {
         return json_encode($data);
     }

    /**output data */
    public static function output($data)
    {
        if(! $data){return;}
        if(! is_string($data)){
            $data = static::json($data);
        }
        echo $data;
    }
   
}