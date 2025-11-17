<?php

namespace Database\Seeders;

use App\Models\FlavorTag;
use Illuminate\Database\Seeder;

class FlavorTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $flavorTags = [
            // Fruity
            ['name' => 'Blueberry', 'category' => 'fruity'],
            ['name' => 'Strawberry', 'category' => 'fruity'],
            ['name' => 'Cherry', 'category' => 'fruity'],
            ['name' => 'Blackberry', 'category' => 'fruity'],
            ['name' => 'Citrus', 'category' => 'fruity'],
            ['name' => 'Lemon', 'category' => 'fruity'],
            ['name' => 'Orange', 'category' => 'fruity'],
            ['name' => 'Peach', 'category' => 'fruity'],
            ['name' => 'Apple', 'category' => 'fruity'],
            ['name' => 'Grape', 'category' => 'fruity'],
            ['name' => 'Tropical', 'category' => 'fruity'],
            ['name' => 'Stone Fruit', 'category' => 'fruity'],

            // Chocolate & Nutty
            ['name' => 'Chocolate', 'category' => 'chocolate'],
            ['name' => 'Dark Chocolate', 'category' => 'chocolate'],
            ['name' => 'Milk Chocolate', 'category' => 'chocolate'],
            ['name' => 'Cocoa', 'category' => 'chocolate'],
            ['name' => 'Hazelnut', 'category' => 'nutty'],
            ['name' => 'Almond', 'category' => 'nutty'],
            ['name' => 'Walnut', 'category' => 'nutty'],
            ['name' => 'Peanut', 'category' => 'nutty'],

            // Floral
            ['name' => 'Jasmine', 'category' => 'floral'],
            ['name' => 'Lavender', 'category' => 'floral'],
            ['name' => 'Rose', 'category' => 'floral'],
            ['name' => 'Hibiscus', 'category' => 'floral'],
            ['name' => 'Floral', 'category' => 'floral'],

            // Sweet & Caramel
            ['name' => 'Caramel', 'category' => 'sweet'],
            ['name' => 'Honey', 'category' => 'sweet'],
            ['name' => 'Brown Sugar', 'category' => 'sweet'],
            ['name' => 'Maple Syrup', 'category' => 'sweet'],
            ['name' => 'Molasses', 'category' => 'sweet'],
            ['name' => 'Vanilla', 'category' => 'sweet'],

            // Spicy
            ['name' => 'Cinnamon', 'category' => 'spicy'],
            ['name' => 'Clove', 'category' => 'spicy'],
            ['name' => 'Nutmeg', 'category' => 'spicy'],
            ['name' => 'Black Pepper', 'category' => 'spicy'],

            // Earthy & Savory
            ['name' => 'Earthy', 'category' => 'earthy'],
            ['name' => 'Woody', 'category' => 'earthy'],
            ['name' => 'Tobacco', 'category' => 'earthy'],
            ['name' => 'Herbal', 'category' => 'earthy'],
            ['name' => 'Cedar', 'category' => 'earthy'],

            // Wine-like
            ['name' => 'Wine-like', 'category' => 'fermented'],
            ['name' => 'Winey', 'category' => 'fermented'],
            ['name' => 'Fermented', 'category' => 'fermented'],

            // Other
            ['name' => 'Buttery', 'category' => 'other'],
            ['name' => 'Creamy', 'category' => 'other'],
            ['name' => 'Smooth', 'category' => 'other'],
            ['name' => 'Bold', 'category' => 'other'],
            ['name' => 'Bright', 'category' => 'other'],
            ['name' => 'Clean', 'category' => 'other'],
            ['name' => 'Complex', 'category' => 'other'],
            ['name' => 'Balanced', 'category' => 'other'],
        ];

        foreach ($flavorTags as $tag) {
            FlavorTag::create($tag);
        }
    }
}
