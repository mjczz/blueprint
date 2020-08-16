<?php

use Illuminate\Database\Seeder;

class HotComplainSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\HotComplain::class, 5)->create();
    }
}
