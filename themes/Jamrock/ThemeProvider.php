<?php

namespace Themes\Jamrock;

use Themes\Jamrock\Car\ModuleProvider;
use Themes\Jamrock\Template\Blocks\AboutContact;

class ThemeProvider extends \Themes\Base\ThemeProvider
{
    public static $version = '1.0.0';
    public static $name = 'Jamrock';
    public static $parent = 'BC';

    public static $jr_modules =[
        'car_jr'=>Car\ModuleProvider::class,
        'tour_jr'=>Tour\ModuleProvider::class,
        'faq_jr'=>Faq\ModuleProvider::class,
        'event_jr'=>Event\ModuleProvider::class,
        'booking_jr'=>Booking\ModuleProvider::class,
        'template_jr'=>Template\ModuleProvider::class,
    ];

    public function register()
    {
        parent::register();
        $this->app->register(UpdaterProvider::class);
        foreach (static::$jr_modules as $module=>$class){
            $this->app->register($class);
        }
    }

    public static function getTemplateBlocks(){
        return [
            'jamrock_about_contact'=>AboutContact::class,
        ];
    }

    public static function getModules()
    {
        return array_merge(static::$modules,static::$jr_modules);
    }
}
