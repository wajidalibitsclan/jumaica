<?php
namespace Themes\Jamrock\Event;

use Modules\Event\Admin\EventController;
use Modules\ModuleServiceProvider;
use Themes\Jamrock\Event\Models\Event;

class ModuleProvider extends ModuleServiceProvider
{

    public function register()
    {
        $this->app->register(RouterServiceProvider::class);
        $this->app->bind(\Modules\Event\Models\Event::class,Event::class);
    }
    public function boot(){
        $this->app->bind(EventController::class,\Themes\Jamrock\Event\Admin\EventController::class);
    }
    public static function getBookableServices()
    {
        if(!Event::isEnable()) return [];
        return [
            'event'=>Event::class
        ];
    }

}
