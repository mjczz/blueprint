<?php

use Illuminate\Database\Seeder;

class HotUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(\App\Models\HotUser::class, 5)->create();
    }
}
