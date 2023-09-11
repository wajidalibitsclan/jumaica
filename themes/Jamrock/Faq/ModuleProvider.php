<?php
namespace Themes\Jamrock\Faq;

use Modules\ModuleServiceProvider;

class ModuleProvider extends ModuleServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/Migrations');
    }

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouterServiceProvider::class);
    }

    public static function getAdminMenu()
    {
        return [
            'Faq'=>[
                "position"=>51,
                'url'        => route('faq.admin.index'),
                'title'      => __("Faqs"),
                'icon'       => 'icon ion-ios-bookmarks',
                'permission' => 'menu_view',
                'children'   => [
                    'all_faq'=>[
                        'url'        => route('faq.admin.index'),
                        'title'      => __("All Faqs"),
                        'permission' => 'menu_view',
                    ],
                    'create_faq'=>[
                        'url'        => route('faq.admin.create'),
                        'title'      => __("Create Faq"),
                        'permission' => 'menu_view',
                    ],
                    'faq_category'=>[
                        'url'        => route('faq.admin.category.index'),
                        'title'      => __('Categories'),
                    ],
                ]
            ],
        ];
    }

}
