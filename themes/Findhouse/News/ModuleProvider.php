<?php

namespace Themes\Findhouse\News;

use Modules\ModuleServiceProvider;
use Themes\Findhouse\Contact\RouterServiceProvider;
use Themes\Findhouse\News\Blocks\ListNews;

class ModuleProvider extends ModuleServiceProvider
{

    public function register()
    {
        $this->app->register(RouterServiceProvider::class);
    }

    public static function getTemplateBlocks()
    {
        return [
            'list_news'=>ListNews::class
        ];
    }
}
