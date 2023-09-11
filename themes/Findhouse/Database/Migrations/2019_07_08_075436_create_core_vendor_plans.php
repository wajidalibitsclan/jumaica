<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoreVendorPlans extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('core_vendor_plans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->integer('base_commission');
            $table->string('status',20)->nullable();
            $table->dateTime('publish_date')->nullable();
            $table->bigInteger('create_user')->nullable();
            $table->bigInteger('update_user')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
        Schema::create('vendors_plan_payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('vendor_id');
            $table->integer('amount');
            $table->string('payment_gateway')->nullable();
            $table->integer('free_trial');
            $table->enum('price_per',['onetime','per_time'])->default('onetime');
            $table->enum('price_unit',['day','month','year'])->default('day');
            $table->string('status',20)->nullable();
            $table->dateTime('end_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('core_vendor_plans');
        Schema::dropIfExists('vendors_plan_payments');
    }
}
