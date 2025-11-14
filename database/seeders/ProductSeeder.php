<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Define your category-to-tag mapping (matches your browsecatalog @php block)
        $categories_map = [
            'Fashion Accessories' => 'fashion-accessories',
            'Collectibles' => 'collectibles',
            'Home Supplies' => 'home-supplies',
            'Luggage & Bags' => 'luggage-bags',
        ];

        // Product data
        $products = [
            ['name' => 'Geto Suguru Charm V1', 'file' => 'catalog-assets/JJK_Bagcharms/getov1.jpg', 'price' => 170.00, 'category' => 'Luggage & Bags'],
            ['name' => 'Geto Suguru Charm V2', 'file' => 'catalog-assets/JJK_Bagcharms/getov2.jpg', 'price' => 170.00, 'category' => 'Luggage & Bags'],
            ['name' => 'Gojo Satoru 6 Eyes Charm', 'file' => 'catalog-assets/JJK_Bagcharms/gojo6eyes.jpg', 'price' => 190.00, 'category' => 'Luggage & Bags'],
            ['name' => 'Gojo Satoru Charm V2', 'file' => 'catalog-assets/JJK_Bagcharms/gojov2.jpg', 'price' => 190.00, 'category' => 'Luggage & Bags'],
            ['name' => 'Gojo Satoru Charm V3', 'file' => 'catalog-assets/JJK_Bagcharms/gojov3.jpg', 'price' => 190.00, 'category' => 'Luggage & Bags'],
            ['name' => 'Gojo Satoru Charm V4', 'file' => 'catalog-assets/JJK_Bagcharms/gojov4.jpg', 'price' => 190.00, 'category' => 'Luggage & Bags'],
            ['name' => 'Itadori Yuji Charm V1', 'file' => 'catalog-assets/JJK_Bagcharms/itadori.jpg', 'price' => 160.00, 'category' => 'Luggage & Bags'],
            ['name' => 'Itadori Yuji Charm V2', 'file' => 'catalog-assets/JJK_Bagcharms/itadoriv2.jpg', 'price' => 160.00, 'category' => 'Luggage & Bags'],
            ['name' => 'Megumi Fushiguro Charm V1', 'file' => 'catalog-assets/JJK_Bagcharms/megumi.jpg', 'price' => 180.00, 'category' => 'Luggage & Bags'],
            ['name' => 'Nanami Kento Charm V1', 'file' => 'catalog-assets/JJK_Bagcharms/nanamiv1.jpg', 'price' => 170.00, 'category' => 'Luggage & Bags'],
            ['name' => 'Nanami Kento Charm V2', 'file' => 'catalog-assets/JJK_Bagcharms/nanamiv2.jpg', 'price' => 170.00, 'category' => 'Luggage & Bags'],
            ['name' => 'Nobara Kugisaki Charm V2', 'file' => 'catalog-assets/JJK_Bagcharms/nobarav2.jpg', 'price' => 150.00, 'category' => 'Luggage & Bags'],
            ['name' => 'Panda Charm', 'file' => 'catalog-assets/JJK_Bagcharms/panda.jpg', 'price' => 140.00, 'category' => 'Luggage & Bags'],
            ['name' => 'Panda Charm V2', 'file' => 'catalog-assets/JJK_Bagcharms/pandav2.jpg', 'price' => 140.00, 'category' => 'Luggage & Bags'],
            ['name' => 'Sukuna Charm V1', 'file' => 'catalog-assets/JJK_Bagcharms/sukunav1.jpg', 'price' => 200.00, 'category' => 'Luggage & Bags'],
            ['name' => 'Toji Fushiguro Charm', 'file' => 'catalog-assets/JJK_Bagcharms/toji.jpg', 'price' => 220.00, 'category' => 'Luggage & Bags'],
            ['name' => 'Yuta Okkotsu Charm V1', 'file' => 'catalog-assets/JJK_Bagcharms/yutav1.jpg', 'price' => 180.00, 'category' => 'Luggage & Bags'],
            ['name' => 'Yuta Okkotsu Charm V2', 'file' => 'catalog-assets/JJK_Bagcharms/yutav2.jpg', 'price' => 180.00, 'category' => 'Luggage & Bags'],
        ];

        foreach ($products as $product) {
            DB::table('products')->insert([
                'name' => $product['name'],
                'price' => $product['price'],
                'stock' => rand(5, 30),
                'category' => $product['category'],
                'description' => $product['name'] . ' — a limited edition JJK-inspired bag charm.',
                'image_path' => 'products/' . $product['file'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
