<?php


namespace Themes\Jamrock\Tour;


use Modules\ModuleServiceProvider;
use Modules\Tour\Admin\TourController;
use Themes\Jamrock\Tour\Models\Tour;

class ModuleProvider extends ModuleServiceProvider
{

    public function register()
    {
        $this->app->register(RouterServiceProvider::class);
        $this->app->bind(\Modules\Tour\Models\Tour::class,Tour::class);
        $this->app->bind(TourController::class,\Themes\Jamrock\Tour\Admin\TourController::class);
    }
    public static function getBookableServices()
    {
        if(!Tour::isEnable()) return [];
        return [
            'tour' => Tour::class,
        ];
    }
}
