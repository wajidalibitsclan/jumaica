<?php
namespace Themes\GoTrip\Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    public function run(){

        Artisan::call('cache:clear');
        $this->call(General::class);
    }
}
