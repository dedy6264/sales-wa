<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
    //    \Artisan::call('laravolt:indonesia:seed');

        $this->call(InitSeeder::class);
        
    }
}
