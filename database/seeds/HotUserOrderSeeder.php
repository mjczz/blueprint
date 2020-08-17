<?php

use Illuminate\Database\Seeder;

class HotUserOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\HotUserOrder::class, 5)->create();
    }
}
