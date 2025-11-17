<?php

namespace Database\Seeders;

use App\Models\Bean;
use App\Models\User;
use App\Models\UserBean;
use Illuminate\Database\Seeder;

class UserBeanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::where('role', 'member')->get();
        $beans = Bean::all();

        $statuses = ['current', 'finished', 'wishlist'];
        $locations = [
            'Local Coffee Shop',
            'Online - Direct from Roaster',
            'Specialty Coffee Store',
            'Whole Foods',
            'Farmers Market',
            'Subscription Box',
            'Gift from Friend',
        ];

        // Give each user 3-7 beans in their collection
        foreach ($users as $user) {
            $numBeans = rand(3, 7);
            $userBeans = $beans->random($numBeans);

            foreach ($userBeans as $bean) {
                UserBean::create([
                    'user_id' => $user->id,
                    'bean_id' => $bean->id,
                    'purchase_date' => now()->subDays(rand(1, 90)),
                    'purchase_location' => $locations[array_rand($locations)],
                    'roast_date' => now()->subDays(rand(5, 100)),
                    'price_paid' => $bean->price ? round($bean->price + (rand(-200, 200) / 100), 2) : null,
                    'status' => $statuses[array_rand($statuses)],
                    'notes' => rand(0, 10) > 6 ? 'Really enjoying this one!' : null,
                ]);
            }
        }
    }
}
