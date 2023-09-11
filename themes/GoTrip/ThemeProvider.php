<?php
namespace Themes\GoTrip;

use Illuminate\Contracts\Http\Kernel;
use Themes\GoTrip\Template\Blocks\FormSearchAllService;

class ThemeProvider extends \Themes\Base\ThemeProvider
{

    public static $version = '1.0.0';
    public static $name = 'Go Trip';
    public static $parent = 'BC';
    public static function info()
    {
        // TODO: Implement info() method.
    }

    public function boot(Kernel $kernel)
    {

        parent::boot($kernel);
        $this->loadMigrationsFrom(__DIR__.'/Database/Migrations');
        //Hook Settings

    }

    public static function getTemplateBlocks(){
        return [
            'form_search_all_service'=>FormSearchAllService::class
        ];
    }

    public function register()
    {
        parent::register();
        $this->app->register(UpdaterProvider::class);
    }

}
