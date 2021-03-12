<?php

namespace Database\Seeders;

use App\Sale;
use App\User;
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
        // $this->call(UsersTableSeeder::class);
        $user = User::factory()->create(['email' => 'admin@meshkay.com']);
        \App\Sale::factory()->count(20)->create(['user_id' => $user->id]);
    }
}
