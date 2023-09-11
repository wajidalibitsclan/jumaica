<?php
namespace Modules\Theme\Abstracts;

use Illuminate\Support\ServiceProvider;

abstract class AbstractThemeProvider extends ServiceProvider
{

    public static $name;

    public static $screenshot;

    public static $version = "1.0";


    public static $modules = [];

    /**
     * Return Theme Info
     *
     * @return array
     */
    static function info(){

    }

    public static function getTemplateBlocks(){
        return [];
    }

    public static function getModules(){
        return static::$modules;
    }

}
