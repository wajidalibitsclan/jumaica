<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateFrom140To150 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bravo_attrs', function (Blueprint $table) {
            if (!Schema::hasColumn('bravo_attrs', 'display_type')) {
                $table->string('display_type',255)->nullable();
            }
            if (!Schema::hasColumn('bravo_attrs', 'hide_in_single')) {
                $table->tinyInteger('hide_in_single')->nullable();
            }
        });
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'verify_submit_status')) {
                $table->string('verify_submit_status',30)->nullable();
            }
            if (!Schema::hasColumn('users', 'is_verified')) {
                $table->smallInteger('is_verified')->nullable();
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

    }
}
