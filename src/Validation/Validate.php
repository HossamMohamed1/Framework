<?php

namespace phplite\Validation;

use phplite\Session\Session;
use Rakit\Validation\Validator;
use phplite\Http\Request;
use phplite\Url\Url;

class Validate{
    private function __construct()
    {
        
    }
    /**
     * Request Validation
     */
    public static function validate(Array $rules , $json )
    {
        $validator = new Validator;

        $validation = $validator->validate($_POST + $_FILES, $rules);

        $errors = $validation->errors();

        if ($validation->fails()) {
            if($json){
                return ['errors' => $errors->firstOfAll()]; 
            }else{
                Session::set('errors' , $errors);
                Session::set('old' , Request::all());
                return Url::redirect(Url::previous());
            }
            
        }

    }

}