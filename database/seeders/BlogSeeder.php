<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user_count = User::count();
        $times = $user_count * $user_count;

        \App\Models\Blog::factory($times)->create();
    }
}
