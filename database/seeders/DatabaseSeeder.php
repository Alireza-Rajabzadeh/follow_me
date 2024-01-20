<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\UserStatusesSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            // UserStatusesSeeder::class
        ]);
        // \App\Models\User::factory(100)->create();


        $this->call([
            // UserCereditsSeeders::class,
            // UserPageSeeders::class,
            // PageFollowSeeder::class
            OrderStatusesSeeder::class,
            OrderDetailsSeeder::class,
        ]);
        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

    }
}
