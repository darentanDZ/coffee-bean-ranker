<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@coffeebean.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'bio' => 'Platform administrator and coffee enthusiast.',
            'location' => 'Seattle, WA',
            'email_verified_at' => now(),
            'brewing_preferences' => [
                'methods' => ['Pour Over', 'Espresso', 'French Press'],
                'favorite_origin' => 'Ethiopia',
            ],
        ]);

        // Create Moderator
        User::create([
            'name' => 'Sarah Johnson',
            'email' => 'moderator@coffeebean.com',
            'password' => Hash::make('password'),
            'role' => 'moderator',
            'bio' => 'Coffee moderator helping maintain our amazing community.',
            'location' => 'Portland, OR',
            'email_verified_at' => now(),
            'instagram_handle' => 'coffeewithsarah',
            'brewing_preferences' => [
                'methods' => ['V60', 'Chemex'],
                'favorite_origin' => 'Kenya',
            ],
        ]);

        // Create Regular Users
        $users = [
            [
                'name' => 'James Martinez',
                'email' => 'james@example.com',
                'bio' => 'Home barista and coffee geek. Always exploring new origins and brewing methods.',
                'location' => 'Austin, TX',
                'instagram_handle' => 'jamesbrewscoffee',
                'brewing_preferences' => [
                    'methods' => ['Aeropress', 'Pour Over'],
                    'favorite_origin' => 'Colombia',
                ],
            ],
            [
                'name' => 'Emily Chen',
                'email' => 'emily@example.com',
                'bio' => 'Espresso enthusiast and latte art practitioner. Love light roasts!',
                'location' => 'San Francisco, CA',
                'twitter_handle' => 'emilycoffee',
                'brewing_preferences' => [
                    'methods' => ['Espresso', 'Moka Pot'],
                    'favorite_origin' => 'Ethiopia',
                ],
            ],
            [
                'name' => 'Michael Thompson',
                'email' => 'michael@example.com',
                'bio' => 'Coffee roaster and Q Grader. Passionate about direct trade relationships.',
                'location' => 'Denver, CO',
                'brewing_preferences' => [
                    'methods' => ['Cupping', 'French Press', 'Pour Over'],
                    'favorite_origin' => 'Guatemala',
                ],
            ],
            [
                'name' => 'Lisa Anderson',
                'email' => 'lisa@example.com',
                'bio' => 'Weekend coffee explorer. On a mission to find the perfect cup.',
                'location' => 'New York, NY',
                'instagram_handle' => 'lisascoffeejourneys',
                'brewing_preferences' => [
                    'methods' => ['Cold Brew', 'Pour Over'],
                    'favorite_origin' => 'Brazil',
                ],
            ],
            [
                'name' => 'David Kim',
                'email' => 'david@example.com',
                'bio' => 'Third wave coffee advocate. Lover of natural processed beans.',
                'location' => 'Los Angeles, CA',
                'brewing_preferences' => [
                    'methods' => ['V60', 'Kalita Wave'],
                    'favorite_origin' => 'Kenya',
                ],
            ],
            [
                'name' => 'Rachel Green',
                'email' => 'rachel@example.com',
                'bio' => 'Coffee blogger and photographer. Capturing the beauty of specialty coffee.',
                'location' => 'Brooklyn, NY',
                'instagram_handle' => 'rachelcoffeepics',
                'twitter_handle' => 'coffeewithrachel',
                'brewing_preferences' => [
                    'methods' => ['Chemex', 'Siphon'],
                    'favorite_origin' => 'Ethiopia',
                ],
            ],
            [
                'name' => 'Tom Wilson',
                'email' => 'tom@example.com',
                'bio' => 'Espresso fanatic. Dialing in the perfect shot one bean at a time.',
                'location' => 'Chicago, IL',
                'brewing_preferences' => [
                    'methods' => ['Espresso'],
                    'favorite_origin' => 'Costa Rica',
                ],
            ],
            [
                'name' => 'Maria Garcia',
                'email' => 'maria@example.com',
                'bio' => 'Coffee educator teaching people about specialty coffee and brewing.',
                'location' => 'Miami, FL',
                'brewing_preferences' => [
                    'methods' => ['Pour Over', 'French Press', 'Cold Brew'],
                    'favorite_origin' => 'Colombia',
                ],
            ],
            [
                'name' => 'Alex Turner',
                'email' => 'alex@example.com',
                'bio' => 'Coffee shop owner and roaster. Supporting sustainable farming practices.',
                'location' => 'Nashville, TN',
                'instagram_handle' => 'alexturnercoffee',
                'brewing_preferences' => [
                    'methods' => ['Espresso', 'Batch Brew', 'Pour Over'],
                    'favorite_origin' => 'Rwanda',
                ],
            ],
            [
                'name' => 'Sophie Martin',
                'email' => 'sophie@example.com',
                'bio' => 'Coffee science nerd. Experimenting with water chemistry and extraction.',
                'location' => 'Boston, MA',
                'brewing_preferences' => [
                    'methods' => ['V60', 'Aeropress'],
                    'favorite_origin' => 'Panama',
                ],
            ],
        ];

        foreach ($users as $userData) {
            User::create(array_merge($userData, [
                'password' => Hash::make('password'),
                'role' => 'member',
                'email_verified_at' => now(),
            ]));
        }

        // Call other seeders
        $this->call([
            FlavorTagSeeder::class,
            BeanSeeder::class,
            ReviewSeeder::class,
            UserBeanSeeder::class,
            DiscussionSeeder::class,
        ]);
    }
}
