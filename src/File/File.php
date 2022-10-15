<?php
namespace phplite\File;

class File{
    private function __construct()
    {
        
    }

    /**Root path */
    public static function root(){
        return Root;
    }
    /**Directory separator */
    public static function ds(){
        return DS;
    }

    /**Get Fille full path */
    public static function path($path){
        $path = static::root() . static::ds() . trim($path , '/');
        $path = str_replace(['/','\\'],static::ds(),$path);
        return $path;
    }
    /**check that file exisstes */
    public static function exist($path){
        return file_exists(static::path($path));
    }
    /**require filee */
    public static function require_file($path)
    {
        if(static::exist($path))
        {
            return require_once static::path($path);
        }
    }
    /**include filee */
    public static function include_file($path)
    {
        if(static::exist($path))
        {
            return include static::path($path);
        }
    }
    /**Require directory */
    public static function require_directory($path){
        $files = array_diff(scandir(static::path($path)),['.','..']);
        foreach($files as $file)
        {
           $file_path = $path . static::ds() . $file;
           if(static::exist($file_path)){
             static::require_file($file_path);
           }
        }
    }

}