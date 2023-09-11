<?php


namespace Themes\Jamrock\Car;


use Modules\Car\Controllers\CarController;
use Modules\ModuleServiceProvider;
use Themes\Jamrock\Car\Models\Car;

class ModuleProvider extends ModuleServiceProvider
{

    public function register()
    {
        $this->app->register(RouterServiceProvider::class);
        $this->app->bind(\Modules\Car\Models\Car::class,Car::class);
        $this->app->bind(CarController::class,\Themes\Jamrock\Car\Controllers\CarController::class);
    }
    public static function getBookableServices()
    {
        if(!Car::isEnable()) return [];
        return [
            'car'=>Car::class
        ];
    }

}
