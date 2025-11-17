<?php

namespace Database\Seeders;

use App\Models\Bean;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $beans = Bean::all();
        $users = User::where('role', 'member')->get();

        $brewingMethods = ['V60', 'Chemex', 'Aeropress', 'French Press', 'Espresso', 'Pour Over', 'Moka Pot', 'Cold Brew', 'Kalita Wave'];

        $reviewTemplates = [
            [
                'rating' => 5.0,
                'text' => 'Absolutely amazing! This coffee exceeded all my expectations. The flavor notes are spot on and it brews beautifully. Will definitely buy again!',
                'would_buy' => true,
            ],
            [
                'rating' => 4.5,
                'text' => 'Really impressed with this one. Great complexity and the flavor profile is exactly as described. Just a touch too acidic for my preference, but still excellent.',
                'would_buy' => true,
            ],
            [
                'rating' => 4.8,
                'text' => 'One of the best coffees I\'ve had this year. The processing method really shines through and creates a unique cup. Highly recommend!',
                'would_buy' => true,
            ],
            [
                'rating' => 4.3,
                'text' => 'Solid coffee with good flavors. Not mind-blowing but very enjoyable and consistent. Great for everyday drinking.',
                'would_buy' => true,
            ],
            [
                'rating' => 4.7,
                'text' => 'Wow! The aroma alone is worth it. Tastes even better than it smells. Perfect balance of sweetness and acidity.',
                'would_buy' => true,
            ],
            [
                'rating' => 3.8,
                'text' => 'Good coffee but didn\'t quite live up to the hype for me. Still enjoyable but I prefer a bit more body.',
                'would_buy' => false,
            ],
            [
                'rating' => 4.6,
                'text' => 'Exceptional quality. You can really taste the care that went into growing and processing these beans. The roast is perfect.',
                'would_buy' => true,
            ],
            [
                'rating' => 4.2,
                'text' => 'Very nice! Smooth and easy to dial in. Makes a great espresso with lovely crema.',
                'would_buy' => true,
            ],
            [
                'rating' => 4.9,
                'text' => 'This is what specialty coffee is all about! Every cup is an experience. The flavor journey from first sip to finish is incredible.',
                'would_buy' => true,
            ],
            [
                'rating' => 3.5,
                'text' => 'Decent but not my favorite. A bit too bright for my taste. Would work well for those who like high acidity.',
                'would_buy' => false,
            ],
            [
                'rating' => 4.4,
                'text' => 'Really enjoying this bean. Great for both espresso and filter. Versatile and delicious.',
                'would_buy' => true,
            ],
            [
                'rating' => 4.1,
                'text' => 'Nice coffee. Clean cup with interesting flavor notes. Price is a bit high but quality is there.',
                'would_buy' => true,
            ],
            [
                'rating' => 4.8,
                'text' => 'Incredible! Best cup I\'ve had in months. The sweetness is natural and the finish is so long and pleasant.',
                'would_buy' => true,
            ],
            [
                'rating' => 4.0,
                'text' => 'Good solid coffee. Nothing spectacular but very reliable and enjoyable.',
                'would_buy' => true,
            ],
            [
                'rating' => 4.5,
                'text' => 'Love the flavor profile on this one. Exactly what I look for in a light roast. Fruity and floral notes are pronounced.',
                'would_buy' => true,
            ],
        ];

        // Add 3-5 reviews to each bean
        foreach ($beans as $bean) {
            $numReviews = rand(3, 5);
            $reviewedUsers = $users->random($numReviews);

            foreach ($reviewedUsers as $user) {
                $template = $reviewTemplates[array_rand($reviewTemplates)];

                // Add some variation to ratings
                $baseRating = $template['rating'];
                $rating = $baseRating + (rand(-2, 2) / 10);
                $rating = max(1.0, min(5.0, $rating)); // Clamp between 1 and 5

                Review::create([
                    'user_id' => $user->id,
                    'bean_id' => $bean->id,
                    'rating_overall' => round($rating, 1),
                    'rating_aroma' => round($rating + (rand(-3, 3) / 10), 1),
                    'rating_acidity' => round($rating + (rand(-4, 2) / 10), 1),
                    'rating_body' => round($rating + (rand(-2, 4) / 10), 1),
                    'rating_flavor' => round($rating + (rand(-2, 3) / 10), 1),
                    'rating_aftertaste' => round($rating + (rand(-3, 2) / 10), 1),
                    'brewing_method' => $brewingMethods[array_rand($brewingMethods)],
                    'review_text' => $template['text'],
                    'would_buy_again' => $template['would_buy'],
                    'helpful_count' => rand(0, 15),
                    'created_at' => now()->subDays(rand(1, 60)),
                ]);
            }
        }
    }
}
