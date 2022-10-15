<?php
namespace phplite\View;
use phplite\File\File;
use Jenssegers\Blade\Blade;
use phplite\Session\Session;

class View{
    private function __construct()
    {
        
    }
        /**Rendering view */
        public static function render($path , $data = []){
            $errors =Session::flash('errors');
            $old =Session::flash('old');
            $data = array_merge($data , ['errors' => $errors , 'old'=>$old]);
            return static::bladerender($path , $data);
        }
    /**Render view file using blade engine*/
    public static function bladerender($path , $data = [])
    {
        $blade = new Blade(File::path('views'), File::path('storage/cache'));
        return $blade->make($path, $data)->render();
    }
    /**Rendering view */
    public static function viewRender($path , $data = []){
        $path = 'views' . File::ds() . str_replace(['/','\\','.'] , File::ds() , $path) . '.php';
        if(! File::exist($path)){
            throw new \Exception("The view file {$path} is not exist");
        }
        ob_start();
        //['name' => 'Hossam', 'age' =>"23"]
        extract($data);
        include File::path($path);
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }
}