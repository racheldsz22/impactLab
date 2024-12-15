<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create([
            'name' => 'Soundcore Sleep A20 ',
            'description' => 'Soundcore Sleep A20 by Anker Sleep Earbuds, Noise Blocking Sleep Headphones, Small Design for Side Sleepers, 80H Playtime, Stream Content via Bluetooth 5.3, Sleep Monitor, Personal Alarm',
            'price' => 250.80,
            'quantity' => 10,
            'image_url' => 'https://m.media-amazon.com/images/I/61lV3lqGSBL._AC_SL1500_.jpg',
        ]);

        // Create additional users with factories (optional)
        Product::factory()->count(10)->create(); // Creates 10 random users
      
    }
}
