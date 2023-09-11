<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateFrom130To140 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bravo_payouts', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('vendor_id')->nullable();
            $table->decimal('amount',10,2)->nullable();
            $table->string('status',50)->nullable();
            $table->string("payout_method",50)->nullable();
            $table->text("account_info")->nullable();

            $table->text("note_to_admin")->nullable();
            $table->text("note_to_vendor")->nullable();
            $table->integer('last_process_by')->nullable();
            $table->timestamp("pay_date")->nullable();// admin pay date

            $table->integer('create_user')->nullable();
            $table->integer('update_user')->nullable();
            $table->timestamps();
        });

//        Schema::table('bravo_bookings', function (Blueprint $table) {
//            if (!Schema::hasColumn('bravo_bookings', 'payout_id')) {
//                $table->bigInteger('payout_id')->nullable();
//            }
//        });


        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'business_name')) {
                $table->string('business_name',255)->nullable();
            }
        });
        Schema::table('bravo_property_translations', function (Blueprint $table) {
            if (!Schema::hasColumn('bravo_property_translations', 'extra_price')) {
                $table->text('extra_price')->nullable();
            }
        });
        Schema::table('bravo_terms', function (Blueprint $table) {
            if (!Schema::hasColumn('bravo_terms', 'icon')) {
                $table->string('icon',50)->nullable();
            }
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bravo_payouts');
    }
}
