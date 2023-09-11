<?php

namespace Themes\Findhouse\Database\Seeders;

use DB;
use Illuminate\Database\Seeder;
use Modules\Media\Models\MediaFile;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('users')->insert([
            'first_name' => 'System',
            'last_name' => 'Admin',
            'email' => 'admin@findhouse.test',
            'password' => bcrypt('admin123'),
            'phone' => '112 666 888',
            'status' => 'publish',
            'email_verified_at' => '2020-09-06 00:00:00',
            'created_at' => date("Y-m-d H:i:s"),
            'avatar_id' => MediaFile::findMediaByName("avatar")->id,
            'bio' => 'We\'re designers who have fallen in love with creating spaces for others to reflect, reset, and create. We split our time between two deserts (the Mojave, and the Sonoran). We love the way the heat sinks into our bones, the vibrant sunsets, and the wildlife we get to call our neighbors.',
            'user_social' => '[{"title":"facebook","code":"fa fa-facebook","link":"#"},{"title":"twitter","code":"fa fa-twitter","link":"#"}]'
        ]);
        $user = \App\User::where('email', 'admin@findhouse.test')->first();
        $user->assignRole('administrator');

        DB::table('users')->insert([
            'first_name' => 'Agent',
            'last_name' => '01',
            'email' => 'vendor1@findhouse.test',
            'password' => bcrypt('123456Aa'),
            'phone' => '112 666 888',
            'status' => 'publish',
            'created_at' => date("Y-m-d H:i:s"),
            'avatar_id' => rand(1, 5),
            'bio' => 'We\'re designers who have fallen in love with creating spaces for others to reflect, reset, and create. We split our time between two deserts (the Mojave, and the Sonoran). We love the way the heat sinks into our bones, the vibrant sunsets, and the wildlife we get to call our neighbors.',
            'user_social' => '[{"title":"facebook","code":"fa fa-facebook","link":"#"},{"title":"twitter","code":"fa fa-twitter","link":"#"}]'
        ]);
        $user = \App\User::where('email', 'vendor1@findhouse.test')->first();
        $user->assignRole('administrator');

        DB::table('users')->insert([
            'first_name' => 'Customer',
            'last_name' => '01',
            'email' => 'customer1@findhouse.test',
            'password' => bcrypt('123456Aa'),
            'phone' => '112 666 888',
            'status' => 'publish',
            'created_at' => date("Y-m-d H:i:s"),
            'avatar_id' => rand(1, 5),
            'bio' => 'We\'re designers who have fallen in love with creating spaces for others to reflect, reset, and create. We split our time between two deserts (the Mojave, and the Sonoran). We love the way the heat sinks into our bones, the vibrant sunsets, and the wildlife we get to call our neighbors.',
            'user_social' => '[{"title":"facebook","code":"fa fa-facebook","link":"#"},{"title":"twitter","code":"fa fa-twitter","link":"#"}]'
        ]);
        $user = \App\User::where('email', 'customer1@findhouse.test')->first();
        $user->assignRole('customer');

        $vendor = [
            ['Elise', 'Aarohi'],
            ['Kaytlyn', 'Alvapriya'],
            ['Lynne', 'Victoria'],
            ['Christopher', 'Pakulla']
        ];
        foreach ($vendor as $k => $v) {
            DB::table('users')->insert([
                'first_name' => $v[0],
                'last_name' => $v[1],
                'email' => $v[1] . '@findhouse.test',
                'password' => bcrypt('123456Aa'),
                'phone' => '891 456 9874',
                'status' => 'publish',
                'created_at' => date("Y-m-d H:i:s"),
                'avatar_id' => rand(1, 5),
                'bio' => 'Evans Tower very high demand corner junior one bedroom plus a large balcony boasting full open NYC views. You need to see the views to believe them. Mint condition with new hardwood floors. Lots of closets plus washer and dryer.
                        Fully furnished. Elegantly appointed condominium unit situated on premier location. PS6. The wide entry hall leads to a large living room with dining area. This expansive 2 bedroom and 2 renovated marble bathroom apartment has great windows. Despite the interior views, the apartments Southern and Eastern exposures allow for lovely natural light to fill every room. The master suite is surrounded by handcrafted milkwork and features incredible walk-in closet and storage space.',
                'user_social' => '[{"title":"facebook","code":"fa fa-facebook","link":"#"},{"title":"twitter","code":"fa fa-twitter","link":"#"}]'
            ]);
            $user = \App\User::where('email', $v[1] . '@findhouse.test')->first();
            $user->assignRole('administrator');
        }

        DB::table('users')->insert([
            'first_name' => 'Do',
            'last_name' => 'Quan',
            'email' => 'quandq@gmail.com',
            'password' => bcrypt('quangquan'),
            'status' => 'publish',
            'created_at' => date("Y-m-d H:i:s")
        ]);
        $user = \App\User::where('email', 'quandq@gmail.com')->first();
        $user->assignRole('administrator');
        $customer = [
            ['William', 'Diana'],
            ['Sarah', 'Violet'],
            ['Paul', 'Amora'],
            ['Richard', 'Davina'],
            ['Shushi', 'Yashashree'],
            ['Anne', 'Nami'],
            ['Bush', 'Elise'],
            ['Elizabeth', 'Norah'],
            ['James', 'Alia'],
            ['John', 'Dakshi'],
        ];
        foreach ($customer as $k => $v) {
            DB::table('users')->insert([
                'first_name' => $v[0],
                'last_name' => $v[1],
                'email' => $v[1] . '@findhouse.test',
                'password' => bcrypt('123456Aa'),
                'phone' => '888 999 777',
                'avatar_id' => rand(1, 5),
                'status' => 'publish',
                'bio' => 'We\'re designers who have fallen in love with creating spaces for others to reflect, reset, and create. We split our time between two deserts (the Mojave, and the Sonoran). We love the way the heat sinks into our bones, the vibrant sunsets, and the wildlife we get to call our neighbors.',
                'created_at' => date("Y-m-d H:i:s"),
                'user_social' => '[{"title":"facebook","code":"fa fa-facebook","link":"#"},{"title":"twitter","code":"fa fa-twitter","link":"#"}]'
            ]);
            $user = \App\User::where('email', $v[1] . '@findhouse.test')->first();
            $user->assignRole('agent');
        }

        DB::table('core_settings')->insert(
            [

                [
                    'name' => 'agent_enable_review',
                    'val' => '1',
                    'group' => "agent",
                ],
                [
                    'name' => 'agent_review_approved',
                    'val' => '0',
                    'group' => "agent",
                ],
                [
                    'name' => 'agent_review_stats',
                    'val' => '[{"title":"Service"},{"title":"Organization"},{"title":"Friendliness"},{"title":"Area Expert"},{"title":"Safety"}]',
                    'group' => "agent",
                ]
            ]
        );
    }
}
