<?php

use Illuminate\Database\Seeder;

class HotBeanExchangeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\HotBeanExchange::class, 5)->create();
    }
}
