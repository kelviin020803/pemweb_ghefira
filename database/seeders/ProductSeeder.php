<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            // SHOES
            [
                'brand' => 'Nike',
                'name' => 'Air Jordan 1 Retro High OG',
                'category' => 'Shoes',
                'price' => 2599000,
                'stock' => 15,
                'description' => 'Sepatu basket klasik dengan desain ikonik yang tidak lekang oleh waktu. Cocok untuk gaya kasual dan olahraga.',
            ],
            [
                'brand' => 'Adidas',
                'name' => 'Yeezy Boost 350 V2',
                'category' => 'Shoes',
                'price' => 3200000,
                'stock' => 8,
                'description' => 'Sneaker premium dengan teknologi Boost untuk kenyamanan maksimal. Limited edition.',
            ],
            [
                'brand' => 'Converse',
                'name' => 'Chuck Taylor All Star High Top',
                'category' => 'Shoes',
                'price' => 899000,
                'stock' => 25,
                'description' => 'Sepatu canvas klasik yang timeless. Cocok untuk berbagai outfit kasual.',
            ],

            // HOODIES
            [
                'brand' => 'Supreme',
                'name' => 'Box Logo Hoodie',
                'category' => 'Hoodie',
                'price' => 1899000,
                'stock' => 12,
                'description' => 'Hoodie streetwear dengan logo box Supreme yang ikonik. Material premium dan nyaman.',

            ],
            [
                'brand' => 'The North Face',
                'name' => 'Drew Peak Pullover Hoodie',
                'category' => 'Hoodie',
                'price' => 1299000,
                'stock' => 20,
                'description' => 'Hoodie outdoor dengan bahan hangat dan tahan lama. Perfect untuk cuaca dingin.',

            ],
            [
                'brand' => 'Champion',
                'name' => 'Reverse Weave Hoodie',
                'category' => 'Hoodie',
                'price' => 999000,
                'stock' => 18,
                'description' => 'Hoodie dengan teknologi reverse weave yang anti-shrink. Nyaman untuk daily wear.',

            ],

            // BAGS
            [
                'brand' => 'Herschel',
                'name' => 'Little America Backpack',
                'category' => 'Bag',
                'price' => 1499000,
                'stock' => 10,
                'description' => 'Backpack dengan desain vintage modern. Cocok untuk kuliah atau travelling.',

            ],
            [
                'brand' => 'Fjallraven',
                'name' => 'Kanken Classic Backpack',
                'category' => 'Bag',
                'price' => 1299000,
                'stock' => 15,
                'description' => 'Tas punggung minimalis dari Swedia. Water resistant dan sangat tahan lama.',

            ],
            [
                'brand' => 'Anello',
                'name' => 'Large Backpack',
                'category' => 'Bag',
                'price' => 699000,
                'stock' => 22,
                'description' => 'Tas ransel multifungsi dengan opening lebar. Cocok untuk daily use.',

            ],

            // JACKETS
            [
                'brand' => 'Levi\'s',
                'name' => 'Trucker Jacket',
                'category' => 'Jacket',
                'price' => 1799000,
                'stock' => 14,
                'description' => 'Jaket denim klasik yang iconic. Must have item untuk wardrobe fashion.',

            ],
            [
                'brand' => 'Uniqlo',
                'name' => 'Ultra Light Down Jacket',
                'category' => 'Jacket',
                'price' => 999000,
                'stock' => 30,
                'description' => 'Jaket ringan dengan insulasi down. Bisa dilipat compact, perfect untuk travel.',

            ],
            [
                'brand' => 'Stussy',
                'name' => 'Stock Coach Jacket',
                'category' => 'Jacket',
                'price' => 1599000,
                'stock' => 16,
                'description' => 'Coach jacket streetwear dengan logo Stussy. Water repellent dan stylish.',

            ],
        ];

        foreach ($products as $product) {
            $product['slug'] = Str::slug($product['name']);
            Product::create($product);
        }
    }
}
