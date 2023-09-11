<?php
namespace Themes\Jamrock;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class UpdaterProvider extends ServiceProvider
{

    public function boot(){
        if (file_exists(storage_path().'/installed') and !app()->runningInConsole()) {
            $this->runUpdateTo100();
            $this->runUpdateTo110();
        }
    }

    public function runUpdateTo100(){
        $version = '1.3.5';
        if (version_compare(setting_item('jr_update_to_110'), $version, '>=')) return;


        if(!Schema::hasTable('bravo_taxi_pricing')) {

            Schema::create('bravo_taxi_pricing', function (Blueprint $table) {
                $table->id();

                $table->bigInteger('car_id')->nullable()->index();
                $table->integer('from')->unsigned()->nullable();
                $table->integer('to')->unsigned()->nullable();

                $table->decimal('oneway_price',10,2)->nullable()->index();
                $table->decimal('oneway_discount',10,2)->nullable()->index();

                $table->decimal('roundtrip_price',10,2)->nullable()->index();
                $table->decimal('roundtrip_discount',10,2)->nullable()->index();


                $table->bigInteger('create_user')->nullable();
                $table->bigInteger('update_user')->nullable();

                $table->timestamps();
            });



        }

        if(!Schema::hasTable('bravo_tour_pricing')) {

            Schema::create('bravo_tour_pricing',function(Blueprint  $table){
                $table->bigIncrements('id');
                $table->bigInteger('tour_id')->nullable();
                $table->integer('gg_from')->unsigned();
                $table->integer('gg_to')->unsigned();
                $table->text('prices')->nullable();

                $table->bigInteger('create_user')->nullable();
                $table->bigInteger('update_user')->nullable();

                $table->timestamps();
            });
            Schema::table('bravo_tours',function(Blueprint $table){
                if(!Schema::hasColumn('bravo_tours','pax_ranger')){
                    $table->text('pax_ranger')->nullable();
                }
            });


        }
        if(!Schema::hasTable('bravo_event_pricing')) {
            Schema::create('bravo_event_pricing', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('tour_id')->nullable();
                $table->integer('gg_from')->unsigned();
                $table->integer('gg_to')->unsigned();
                $table->text('prices')->nullable();

                $table->bigInteger('create_user')->nullable();
                $table->bigInteger('update_user')->nullable();

                $table->timestamps();
            });
            Schema::table('bravo_events', function (Blueprint $table) {
                if (!Schema::hasColumn('bravo_events', 'pax_ranger')) {
                    $table->text('pax_ranger')->nullable();
                }
            });
        }

        if(!Schema::hasTable('bravo_extra')) {
            Schema::create('bravo_extra', function (Blueprint $table) {
                $table->id();

                $table->string('title')->nullable();
                $table->bigInteger('image_id')->unsigned()->nullable();
                $table->string('video_url')->nullable();
                $table->decimal('price', 10, 2)->nullable();
                $table->integer('display_order')->nullable();
                $table->text('include')->nullable();
                $table->text('exclude')->nullable();


                $table->bigInteger('create_user')->nullable();
                $table->bigInteger('update_user')->nullable();

                $table->timestamps();
            });
        }
        if(!Schema::hasTable('bravo_booking_extra')) {
            Schema::create('bravo_booking_extra', function (Blueprint $table) {
                $table->id();

                $table->bigInteger('booking_id')->unsigned()->nullable();
                $table->bigInteger('extra_id')->unsigned()->nullable();
                $table->decimal('price', 10, 2)->nullable();
                $table->integer('number')->nullable();


                $table->bigInteger('create_user')->nullable();
                $table->bigInteger('update_user')->nullable();

                $table->timestamps();
            });
        }

        if(!Schema::hasTable('bravo_faq')) {
            Schema::create('bravo_faq', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('title');
                $table->text('content')->nullable();
                $table->integer('type');
                $table->integer('create_user')->nullable();
                $table->integer('update_user')->nullable();
                $table->timestamps();
            });
        }
        //add faq translation
        if (!Schema::hasTable('bravo_faq_translations')){
            Schema::create('bravo_faq_translations', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->integer('origin_id')->unsigned();
                $table->string('locale')->index();
                //Info
                $table->string('title', 255)->nullable();
                $table->text('content')->nullable();
                $table->bigInteger('create_user')->nullable();
                $table->bigInteger('update_user')->nullable();
                $table->timestamps();
            });
        }
        if (!Schema::hasTable('bravo_faq_category')){
            Schema::create('bravo_faq_category', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name',255)->nullable();
                $table->text('content')->nullable();
                $table->string('slug',255)->nullable();
                $table->string('status',50)->nullable();
                $table->nestedSet();
                $table->integer('create_user')->nullable();
                $table->integer('update_user')->nullable();
                $table->softDeletes();
                $table->timestamps();
            });
        }
        if (!Schema::hasTable('bravo_faq_category_translations')){
            Schema::create('bravo_faq_category_translations', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->bigInteger('origin_id')->nullable();
                $table->string('locale',10)->nullable();
                $table->string('name',255)->nullable();
                $table->text('content')->nullable();
                $table->integer('create_user')->nullable();
                $table->integer('update_user')->nullable();
                $table->unique(['origin_id', 'locale']);
                $table->timestamps();
            });
        }

        setting_update_item('jr_update_to_110',$version);
    }
    public function runUpdateTo110(){
        $version = '1.6';
        if (version_compare(setting_item('jr_update_to_120'), $version, '>=')) return;


        Schema::table('bravo_events', function (Blueprint $table) {
            if (!Schema::hasColumn('bravo_events', 'display_order')) {
                $table->integer('display_order')->nullable()->default(100);
            }
            if (!Schema::hasColumn('bravo_events', 'duration_text')) {
                $table->string('duration_text')->nullable();
            }
        });
        Schema::table('bravo_cars', function (Blueprint $table) {
            if (!Schema::hasColumn('bravo_cars', 'display_order')) {
                $table->integer('display_order')->nullable()->default(100);
            }
        });
        Schema::table('bravo_tours', function (Blueprint $table) {
            if (!Schema::hasColumn('bravo_tours', 'display_order')) {
                $table->integer('display_order')->nullable()->default(100);
            }
            if (!Schema::hasColumn('bravo_tours', 'duration_text')) {
                $table->string('duration_text')->nullable();
            }
        });

        if(!Schema::hasTable('bravo_popular_locations')) {
            Schema::create('bravo_popular_locations', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name', 255)->nullable();
                $table->integer('image_id')->nullable();
                $table->string('map_lat', 20)->nullable();
                $table->string('map_lng', 20)->nullable();
                $table->integer('map_zoom')->nullable();
                $table->string('status', 50)->nullable();

                $table->integer('create_user')->nullable();
                $table->integer('update_user')->nullable();


                $table->timestamps();
            });
        }

        Schema::table('bravo_popular_locations', function (Blueprint $table) {
            if (!Schema::hasColumn('bravo_popular_locations', 'map_place_id')) {
                $table->string('map_place_id')->nullable();
            }
        });

        setting_update_item('jr_update_to_120',$version);
    }
}
