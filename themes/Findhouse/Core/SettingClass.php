<?php

namespace Themes\Findhouse\Core;

use Modules\Core\Abstracts\BaseSettingsClass;

class SettingClass extends BaseSettingsClass
{

    public static function getSettingPages()
    {
        return [
            'general'=>[
                'id'   => 'general',
                'title' => __("General Settings"),
                'position'=>10,
                'view'=>"Core::admin.settings.general",
                'keys'=>[
                    'site_title',
                    'site_desc',
                    'site_favicon',
                    'admin_email',
                    'email_from_name',
                    'email_from_address',
                    'home_page_id',
                    'topbar_left_text',
                    'logo_id',
                    'logo_id_tran',
                    'logo_id_mb',
                    'footer_text_left',
                    'footer_text_right',
                    'list_widget_footer',
                    'date_format',
                    'site_timezone',
                    'site_locale',
                    'site_first_day_of_the_weekin_calendar',
                    'site_enable_multi_lang',
                    'enable_rtl',

                    'page_contact_title',
                    'page_contact_sub_title',
                    'page_contact_desc',
                    'page_contact_image',
                    'list_info_contact',
                    'map_contact_lat',
                    'map_contact_long',
                    'map_contact_zoom',
                    'contact_partners_title',
                    'contact_partners_sub_title',
                    'contact_partners_button_text',
                    'contact_partners_button_link',

                    'error_404_banner',
                    'error_title',
                    'error_desc',
                    'enable_contact_recaptcha',
                ]
            ]
        ];
    }
}
