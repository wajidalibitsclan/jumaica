<?php

namespace Themes\Findhouse\Contact;

use Modules\ModuleServiceProvider;

class ModuleProvider extends \Modules\Contact\ModuleProvider
{

    public function register()
    {
        $this->app->register(RouterServiceProvider::class);
    }

    public static function getAdminMenu()
    {
        return [
            'contact'=>[
                "position"=>110,
                'url'        => 'admin/module/contact',
                'title'      => __('Contact Submissions'),
                'icon'       => 'icon ion ion-md-mail',
                'permission' => 'contact_manage'
            ],
        ];
    }
}
