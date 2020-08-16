<?php

use Illuminate\Database\Seeder;

class HotPayAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\HotPayAccount::class, 5)->create();
    }
}
