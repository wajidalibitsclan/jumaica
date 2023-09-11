<?php

namespace Themes\Findhouse\Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Report
        Permission::findOrCreate('report_view');

        // Contact Submissions
        Permission::findOrCreate('contact_manage');

        //Newsletter
        Permission::findOrCreate('newsletter_manage');

        // Language
        Permission::findOrCreate('language_manage');
        Permission::findOrCreate('language_translation');


        // Booking
        Permission::findOrCreate('booking_view');
        Permission::findOrCreate('booking_update');
        Permission::findOrCreate('booking_manage_others');

        // Booking
        Permission::findOrCreate('enquiry_view');
        Permission::findOrCreate('enquiry_update');
        Permission::findOrCreate('enquiry_manage_others');


        // Templates
        Permission::findOrCreate('template_view');
        Permission::findOrCreate('template_create');
        Permission::findOrCreate('template_update');
        Permission::findOrCreate('template_delete');


        // News
        Permission::findOrCreate('news_view');
        Permission::findOrCreate('news_create');
        Permission::findOrCreate('news_update');
        Permission::findOrCreate('news_delete');
        Permission::findOrCreate('news_manage_others');

        // Roles
        Permission::findOrCreate('role_view');
        Permission::findOrCreate('role_create');
        Permission::findOrCreate('role_update');
        Permission::findOrCreate('role_delete');

        Permission::findOrCreate('permission_view');
        Permission::findOrCreate('permission_create');
        Permission::findOrCreate('permission_update');
        Permission::findOrCreate('permission_delete');

        // Dashboard
        Permission::findOrCreate('dashboard_access');
        Permission::findOrCreate('dashboard_agent_access');

        // Settings
        Permission::findOrCreate('setting_update');


        // Menus
        Permission::findOrCreate('menu_view');
        Permission::findOrCreate('menu_create');
        Permission::findOrCreate('menu_update');
        Permission::findOrCreate('menu_delete');


        // create permissions
        Permission::findOrCreate('user_view');
        Permission::findOrCreate('user_create');
        Permission::findOrCreate('user_update');
        Permission::findOrCreate('user_delete');

        Permission::findOrCreate('page_view');
        Permission::findOrCreate('page_create');
        Permission::findOrCreate('page_update');
        Permission::findOrCreate('page_delete');
        Permission::findOrCreate('page_manage_others');

        Permission::findOrCreate('setting_view');
        Permission::findOrCreate('setting_update');

        // Media
        Permission::findOrCreate('media_upload');
        Permission::findOrCreate('media_manage');

        // Agencies
        Permission::findOrCreate('agencies_view');
        Permission::findOrCreate('agencies_create');
        Permission::findOrCreate('agencies_update');
        Permission::findOrCreate('agencies_delete');

        // Location
        Permission::findOrCreate('location_view');
        Permission::findOrCreate('location_create');
        Permission::findOrCreate('location_update');
        Permission::findOrCreate('location_delete');
        Permission::findOrCreate('location_manage_others');

        //Review
        Permission::findOrCreate('review_manage_others');

        // Other System Permissions

        Permission::findOrCreate('system_log_view');
        // Property
        Permission::findOrCreate('property_view');
        Permission::findOrCreate('property_create');
        Permission::findOrCreate('property_update');
        Permission::findOrCreate('property_delete');
        Permission::findOrCreate('property_manage_others');
        Permission::findOrCreate('property_manage_attributes');
        // Social
        Permission::findOrCreate('social_manage_forum');

        // Plugin
        Permission::findOrCreate('plugin_manage');

        // Agent
        Permission::findOrCreate('agent_payout_view');
        Permission::findOrCreate('agent_payout_manage');


        // this can be done as separate statements
        $this->initAgent();

        // this can be done as separate statements
        $customer = Role::findOrCreate('customer');

        $role = Role::findOrCreate('administrator');

        $role->givePermissionTo(Permission::all());
    }

    public function initAgent()
    {

        $agent = Role::findOrCreate('agent');

        $agent->givePermissionTo('property_view');
        $agent->givePermissionTo('property_create');
        $agent->givePermissionTo('property_update');
        $agent->givePermissionTo('property_delete');
        $agent->givePermissionTo('dashboard_agent_access');
    }
}
