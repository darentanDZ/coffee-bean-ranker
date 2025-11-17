<?php

namespace Database\Seeders;

use App\Models\Bean;
use App\Models\FlavorTag;
use App\Models\User;
use Illuminate\Database\Seeder;

class BeanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::where('role', '!=', 'admin')->get();
        $allFlavorTags = FlavorTag::all();

        $beans = [
            [
                'name' => 'Yirgacheffe Natural',
                'roaster' => 'Counter Culture Coffee',
                'origin_country' => 'Ethiopia',
                'origin_region' => 'Yirgacheffe',
                'farm' => 'Worka Cooperative',
                'altitude' => 1900,
                'roast_level' => 'light',
                'processing_method' => 'natural',
                'varietal' => 'Heirloom',
                'price' => 18.50,
                'bag_size_grams' => 340,
                'description' => 'Bright and fruit-forward with notes of blueberry, strawberry, and floral jasmine. This naturally processed Ethiopian coffee showcases the best of what Yirgacheffe has to offer.',
                'flavor_tags' => ['Blueberry', 'Strawberry', 'Jasmine', 'Bright', 'Floral'],
            ],
            [
                'name' => 'La Minita Tarrazu',
                'roaster' => 'Intelligentsia Coffee',
                'origin_country' => 'Costa Rica',
                'origin_region' => 'Tarrazu',
                'farm' => 'La Minita Estate',
                'altitude' => 1600,
                'roast_level' => 'medium',
                'processing_method' => 'washed',
                'varietal' => 'Caturra, Catuai',
                'price' => 22.00,
                'bag_size_grams' => 340,
                'description' => 'Classic Costa Rican profile with bright acidity, chocolate notes, and a clean finish. Perfectly balanced and incredibly smooth.',
                'flavor_tags' => ['Chocolate', 'Citrus', 'Clean', 'Balanced', 'Bright'],
            ],
            [
                'name' => 'Huila Supremo',
                'roaster' => 'Blue Bottle Coffee',
                'origin_country' => 'Colombia',
                'origin_region' => 'Huila',
                'altitude' => 1750,
                'roast_level' => 'medium',
                'processing_method' => 'washed',
                'varietal' => 'Caturra, Typica',
                'price' => 16.50,
                'bag_size_grams' => 340,
                'description' => 'Sweet and balanced Colombian coffee with caramel, brown sugar, and nutty undertones. Perfect for any brewing method.',
                'flavor_tags' => ['Caramel', 'Brown Sugar', 'Hazelnut', 'Smooth', 'Balanced'],
            ],
            [
                'name' => 'Kenya AA Kiambu',
                'roaster' => 'Stumptown Coffee Roasters',
                'origin_country' => 'Kenya',
                'origin_region' => 'Kiambu',
                'farm' => 'Gatomboya Cooperative',
                'altitude' => 1800,
                'roast_level' => 'light',
                'processing_method' => 'washed',
                'varietal' => 'SL-28, SL-34',
                'price' => 20.00,
                'bag_size_grams' => 340,
                'description' => 'Quintessential Kenyan coffee with vibrant acidity, blackcurrant, and winey notes. Complex and incredibly aromatic.',
                'flavor_tags' => ['Blackberry', 'Wine-like', 'Citrus', 'Complex', 'Bright'],
            ],
            [
                'name' => 'Sumatra Mandheling',
                'roaster' => 'Peet\'s Coffee',
                'origin_country' => 'Indonesia',
                'origin_region' => 'Sumatra',
                'altitude' => 1500,
                'roast_level' => 'dark',
                'processing_method' => 'washed',
                'varietal' => 'Catimor, Typica',
                'price' => 15.99,
                'bag_size_grams' => 340,
                'description' => 'Full-bodied and earthy with notes of dark chocolate, tobacco, and cedar. Low acidity with a syrupy body.',
                'flavor_tags' => ['Dark Chocolate', 'Earthy', 'Tobacco', 'Bold', 'Woody'],
            ],
            [
                'name' => 'Guatemala Antigua',
                'roaster' => 'La Colombe Coffee Roasters',
                'origin_country' => 'Guatemala',
                'origin_region' => 'Antigua',
                'farm' => 'Finca Azotea',
                'altitude' => 1650,
                'roast_level' => 'medium',
                'processing_method' => 'washed',
                'varietal' => 'Bourbon, Catuai',
                'price' => 17.50,
                'bag_size_grams' => 340,
                'description' => 'Rich and chocolatey with spice notes and a velvety body. A crowd-pleasing coffee that works great with milk.',
                'flavor_tags' => ['Chocolate', 'Cinnamon', 'Caramel', 'Smooth', 'Balanced'],
            ],
            [
                'name' => 'Brazil Cerrado',
                'roaster' => 'Verve Coffee Roasters',
                'origin_country' => 'Brazil',
                'origin_region' => 'Cerrado',
                'altitude' => 1100,
                'roast_level' => 'medium',
                'processing_method' => 'natural',
                'varietal' => 'Yellow Bourbon',
                'price' => 14.00,
                'bag_size_grams' => 340,
                'description' => 'Sweet and nutty Brazilian coffee with notes of peanut, chocolate, and brown sugar. Low acidity and very approachable.',
                'flavor_tags' => ['Peanut', 'Chocolate', 'Brown Sugar', 'Smooth', 'Creamy'],
            ],
            [
                'name' => 'Rwanda Bourbon',
                'roaster' => 'Onyx Coffee Lab',
                'origin_country' => 'Rwanda',
                'origin_region' => 'Nyamasheke',
                'farm' => 'Kinini Washing Station',
                'altitude' => 1850,
                'roast_level' => 'light',
                'processing_method' => 'washed',
                'varietal' => 'Red Bourbon',
                'price' => 19.00,
                'bag_size_grams' => 340,
                'description' => 'Elegant and tea-like with notes of orange, jasmine, and honey. Beautifully clean and delicate.',
                'flavor_tags' => ['Orange', 'Jasmine', 'Honey', 'Clean', 'Floral'],
            ],
            [
                'name' => 'Panama Geisha',
                'roaster' => 'Heart Coffee Roasters',
                'origin_country' => 'Panama',
                'origin_region' => 'Boquete',
                'farm' => 'Hacienda La Esmeralda',
                'altitude' => 1700,
                'roast_level' => 'light',
                'processing_method' => 'washed',
                'varietal' => 'Geisha',
                'price' => 45.00,
                'bag_size_grams' => 227,
                'description' => 'Legendary Panamanian Geisha with incredible floral notes, tropical fruit, and jasmine. One of the most sought-after coffees in the world.',
                'flavor_tags' => ['Jasmine', 'Tropical', 'Floral', 'Complex', 'Bergamot'],
            ],
            [
                'name' => 'Burundi Long Miles',
                'roaster' => 'Passenger Coffee',
                'origin_country' => 'Burundi',
                'origin_region' => 'Kayanza',
                'farm' => 'Long Miles Coffee Project',
                'altitude' => 1700,
                'roast_level' => 'light',
                'processing_method' => 'washed',
                'varietal' => 'Bourbon',
                'price' => 18.00,
                'bag_size_grams' => 340,
                'description' => 'Juicy and fruit-forward with notes of cherry, brown sugar, and citrus. Bright acidity with a syrupy body.',
                'flavor_tags' => ['Cherry', 'Brown Sugar', 'Citrus', 'Bright', 'Complex'],
            ],
            [
                'name' => 'Peru Cajamarca',
                'roaster' => 'Equator Coffees',
                'origin_country' => 'Peru',
                'origin_region' => 'Cajamarca',
                'altitude' => 1600,
                'roast_level' => 'medium',
                'processing_method' => 'washed',
                'varietal' => 'Typica, Caturra',
                'price' => 15.50,
                'bag_size_grams' => 340,
                'description' => 'Sweet and balanced Peruvian coffee with notes of milk chocolate, almond, and caramel. Great for everyday drinking.',
                'flavor_tags' => ['Milk Chocolate', 'Almond', 'Caramel', 'Balanced', 'Smooth'],
            ],
            [
                'name' => 'El Salvador Pacamara',
                'roaster' => 'George Howell Coffee',
                'origin_country' => 'El Salvador',
                'origin_region' => 'Santa Ana',
                'farm' => 'Finca El Carmen',
                'altitude' => 1500,
                'roast_level' => 'light',
                'processing_method' => 'honey',
                'varietal' => 'Pacamara',
                'price' => 21.00,
                'bag_size_grams' => 340,
                'description' => 'Unique Pacamara variety with huge beans and even bigger flavor. Notes of stone fruit, honey, and florals.',
                'flavor_tags' => ['Stone Fruit', 'Honey', 'Floral', 'Complex', 'Bright'],
            ],
            [
                'name' => 'Decaf Colombia',
                'roaster' => 'Counter Culture Coffee',
                'origin_country' => 'Colombia',
                'origin_region' => 'Huila',
                'altitude' => 1700,
                'roast_level' => 'medium',
                'processing_method' => 'washed',
                'varietal' => 'Caturra',
                'price' => 16.00,
                'bag_size_grams' => 340,
                'description' => 'Swiss Water Process decaf that tastes like real coffee! Chocolate, caramel, and nutty notes shine through.',
                'flavor_tags' => ['Chocolate', 'Caramel', 'Hazelnut', 'Smooth', 'Balanced'],
            ],
            [
                'name' => 'Hawaiian Kona Extra Fancy',
                'roaster' => 'Kona Coffee Purveyors',
                'origin_country' => 'United States',
                'origin_region' => 'Hawaii, Kona',
                'altitude' => 600,
                'roast_level' => 'medium',
                'processing_method' => 'washed',
                'varietal' => 'Typica',
                'price' => 38.00,
                'bag_size_grams' => 227,
                'description' => 'Premium Hawaiian Kona with buttery body, brown sugar sweetness, and mild acidity. Smooth and rich.',
                'flavor_tags' => ['Brown Sugar', 'Buttery', 'Smooth', 'Balanced', 'Clean'],
            ],
            [
                'name' => 'Honduras Catracha',
                'roaster' => 'Sweet Maria\'s',
                'origin_country' => 'Honduras',
                'origin_region' => 'Marcala',
                'altitude' => 1500,
                'roast_level' => 'medium',
                'processing_method' => 'washed',
                'varietal' => 'Catuai, Lempira',
                'price' => 13.50,
                'bag_size_grams' => 340,
                'description' => 'Value-driven Honduran coffee with chocolate, caramel, and apple notes. Great bang for your buck!',
                'flavor_tags' => ['Chocolate', 'Caramel', 'Apple', 'Balanced', 'Smooth'],
            ],
        ];

        foreach ($beans as $index => $beanData) {
            // Assign random user as creator
            $user = $users->random();

            $flavorTagNames = $beanData['flavor_tags'];
            unset($beanData['flavor_tags']);

            $bean = Bean::create(array_merge($beanData, [
                'created_by_user_id' => $user->id,
                'verified' => rand(0, 10) > 3, // 70% chance of being verified
            ]));

            // Attach flavor tags
            $flavorTagIds = FlavorTag::whereIn('name', $flavorTagNames)->pluck('id');
            $bean->flavorTags()->attach($flavorTagIds);
        }
    }
}
