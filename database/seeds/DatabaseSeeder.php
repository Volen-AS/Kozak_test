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
        factory(App\Models\User::class, 20)->create()->each(function($user) {
            $user->posts()->saveMany(factory(App\Models\Post::class, 10)->make());
        });
    }
}
