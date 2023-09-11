<?php
namespace Themes\Jamrock\Booking;

use Modules\Booking\Models\Booking;
use Modules\ModuleServiceProvider;

class ModuleProvider extends ModuleServiceProvider
{
    public function boot()
    {
    }

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouterServiceProvider::class);
        $this->app->bind(Booking::class,\Themes\Jamrock\Booking\Models\Booking::class);
    }

    public static function getAdminMenu()
    {
        return [
            'extra'=>[
                "position"=>51,
                'url'        => route('extra.admin.index'),
                'title'      => __("Extras"),
                'icon'       => 'icon ion-ios-bookmarks',
                'permission' => 'menu_view',
                'children'   => [
                    'all_faq'=>[
                        'url'        => route('extra.admin.index'),
                        'title'      => __("All Extra"),
                        'permission' => 'menu_view',
                    ],
                    'create_faq'=>[
                        'url'        => route('extra.admin.create'),
                        'title'      => __("Create Extra"),
                        'permission' => 'menu_view',
                    ],
                    'dropdown'=>[
                        'url'        => route('dropdown.admin.index'),
                        'title'      => __("Dropdown"),
                        'permission' => 'menu_view',
                    ],
                    'Combination'=>[
                        'url'        => route('combination.admin.index'),
                        'title'      => __("Combination"),
                        'permission' => 'menu_view',
                    ]
                ]
            ],
        ];
    }

}
