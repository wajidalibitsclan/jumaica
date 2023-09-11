<?php

namespace Themes\Base\Core\Updaters;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Modules\Tour\Models\Tour;
use Modules\User\Models\Plan;
use Spatie\Permission\Models\Role;

class Updater250
{

    public static function run(){
        $version = '1.5.5';
        if (version_compare(setting_item('update_to_250'), $version, '>=')) return;

        Artisan::call('migrate', [
            '--force' => true,
        ]);

        if(!setting_item('user_role')){
            setting_update_item('user_role',2);
        }

        Schema::table('bravo_boats', function (Blueprint $table) {
            if (!Schema::hasColumn('bravo_boats', 'start_time_booking')) {
                $table->string('start_time_booking')->nullable();
            }
            if (!Schema::hasColumn('bravo_boats', 'end_time_booking')) {
                $table->string('end_time_booking')->nullable();
            }
        });

        setting_update_item('update_to_250',$version);

        $vendor = Role::findOrCreate('vendor');
        $vendor->givePermissionTo('news_view');
        $vendor->givePermissionTo('news_create');
        $vendor->givePermissionTo('news_update');
        $vendor->givePermissionTo('news_delete');


        // Booking Passengers
        if(\Illuminate\Support\Facades\Schema::hasTable('booking_passengers')){
            Schema::rename('booking_passengers','bravo_booking_passengers');
        }

        if(Schema::hasTable('bravo_booking_passengers')){
            Schema::table('bravo_booking_passengers',function(Blueprint $blueprint){
                if(!Schema::hasColumn('bravo_booking_passengers','object_model')){
                    $blueprint->string('object_model',30);
                    $blueprint->bigInteger('object_id')->nullable();
                    $blueprint->index('booking_id');
                    $blueprint->index(['object_model','object_id']);
                }
            });
        }

        if(Schema::hasTable((new Tour())->getTable())){
            Schema::table((new Tour())->getTable(),function(Blueprint $table){
                if(!Schema::hasColumn((new Tour())->getTable(),'enable_fixed_date')){
                    $table->tinyInteger('enable_fixed_date')->default(false)->nullable();
                    $table->dateTime('start_date')->nullable();
                    $table->datetime('end_date')->nullable();
                    $table->dateTime('last_booking_date')->nullable();
                }
            });
        }


        // User Plan
        if(!Schema::hasTable('bravo_plans')) {
            Schema::create('bravo_plans', function (Blueprint $table) {
                $table->id();

                $table->string('title')->nullable();
                $table->text('content')->nullable();
                $table->decimal('price', 12, 2)->nullable();
                $table->integer('duration')->nullable()->default(0);
                $table->string('duration_type', 30)->nullable();
                $table->decimal('annual_price', 12, 2)->nullable();
                $table->integer('max_service')->nullable()->default(0);

                $table->string('status', 30)->nullable();

                $table->bigInteger('role_id')->nullable();
                $table->tinyInteger('is_recommended')->nullable()->default(1);

                $table->softDeletes();
                $table->bigInteger('create_user')->nullable();
                $table->bigInteger('update_user')->nullable();
                $table->timestamps();
            });
        }
        if(!Schema::hasTable('bravo_plan_trans')) {

            Schema::create('bravo_plan_trans', function (Blueprint $table) {
                $table->id();

                $table->string('title')->nullable();
                $table->text('content')->nullable();

                $table->bigInteger('create_user')->nullable();
                $table->bigInteger('update_user')->nullable();
                $table->integer('origin_id')->unsigned();
                $table->string('locale')->index();

                $table->unique(['origin_id', 'locale']);

                $table->softDeletes();

                $table->timestamps();
            });
        }

        if(!Schema::hasTable('bravo_user_plan')) {
            Schema::create('bravo_user_plan', function (Blueprint $table) {
                $table->id();

                $table->bigInteger('plan_id');
                $table->timestamp('start_date')->nullable();
                $table->timestamp('end_date')->nullable();
                $table->integer('max_service')->nullable()->default(0);
                $table->decimal('price', 12, 2)->nullable();
                $table->text("plan_data")->nullable();

                $table->tinyInteger('status')->nullable()->default(1);

                $table->bigInteger('create_user')->nullable();
                $table->bigInteger('update_user')->nullable();
                $table->timestamps();
            });
        }

        if(Plan::get()->count()<=0){
            $plans = [
                'Basic',
                'Standard',
                'Extended',
            ];
            $prices = [199,499,799];
            $count = [5,20,50];
            $roleVendor = Role::findByName('vendor');

            foreach ($plans as $k=>$plan){
                $a = new Plan();
                $data = [
                    'title'=>$plan,
                    'price'=>$prices[$k],
                    'duration'=>1,
                    'duration_type'=>'month',
                    'annual_price'=>$prices[$k] + 1000,
                    'is_recommended'=>$k == 1 ? 1 : 0,
                    'content'=>'',
                    'max_service'=>$count[$k],
                    'role_id'=>$roleVendor->id,
                    'status'=>'publish'
                ];
                $a->fillByAttr(array_keys($data),$data);
                $a->save();
            }
        }
        if(empty(setting_item('user_plans_page_title'))){
            setting_update_item('user_plans_page_title','Pricing Packages');
        }
        if(empty(setting_item('user_plans_page_sub_title'))){
            setting_update_item('user_plans_page_sub_title','Choose your pricing plan');
        }
        if(empty(setting_item('user_plans_sale_text'))){
            setting_update_item('user_plans_sale_text','Save up to 10%');
        }

        setting_update_item('booking_enquiry_for_hotel','1');
        setting_update_item('booking_enquiry_type_hotel','booking_and_enquiry');
        setting_update_item('booking_enquiry_for_tour','1');
        setting_update_item('booking_enquiry_type_tour','booking_and_enquiry');
        setting_update_item('booking_enquiry_for_space','1');
        setting_update_item('booking_enquiry_type_space','booking_and_enquiry');
        setting_update_item('booking_enquiry_for_car','1');
        setting_update_item('booking_enquiry_type_car','booking_and_enquiry');
        setting_update_item('booking_enquiry_for_event','1');
        setting_update_item('booking_enquiry_type_event','booking_and_enquiry');
        setting_update_item('booking_enquiry_for_boat','1');
        setting_update_item('booking_enquiry_type_boat','booking_and_enquiry');

        Artisan::call('cache:clear');
    }
}
