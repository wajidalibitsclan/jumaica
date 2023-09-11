<?php
namespace Modules;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public function boot()
    {
        $listModule = array_map('basename', \Illuminate\Support\Facades\File::directories(__DIR__));
        foreach ($listModule as $module) {
            if (is_dir(__DIR__ . '/' . $module . '/Views')) {
                $this->loadViewsFrom(__DIR__ . '/' . $module . '/Views', $module);
            }
        }
        if (is_dir(__DIR__ . '/Layout')) {
            $this->loadViewsFrom(__DIR__ . '/Layout', 'Layout');
        }

    }

    public function register()
    {

    }


    public static function getModules(){
        return array_keys(static::getActivatedModules());
    }

    public static function getActivatedModules($noTheme = false){
        $res = [];

        $class = \Modules\Theme\ThemeManager::currentProvider();
        if(class_exists($class)){
            foreach ($class::getModules() as $module=>$class){
                if(class_exists($class)) {
                    $res[$module] = [
                        'id'=>$module,
                        'class'=>$class
                    ];
                }
            }
        }

        return $res;
    }

}
