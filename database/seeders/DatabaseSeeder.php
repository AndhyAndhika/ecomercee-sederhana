<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::create([
            'name' => "Andhika Nur Rohman",
            'email' => "admin@gmail.com",
            'password' => Hash::make('admin'),
            'role' => 99,
        ]);

        /* Seeder for Banners */
        $banner = [
            [
                'name' => 'Cacao Banner',
                'picture' => 'img/banner/' . Str::slug('Cacao Banner') . '.webp',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Koji Experimental',
                'picture' => 'img/banner/' . Str::slug('Koji Experimental') . '.webp',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Pengiriman Setiap Hari',
                'picture' => 'img/banner/' . Str::slug('Pengiriman Setiap Hari') . '.webp',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'April Gift 2025',
                'picture' => 'img/banner/' . Str::slug('April Gift 2025') . '.webp',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        \App\Models\Banner::insert($banner);

        /* seeder for products */
        $products = [
            [
                'name' => 'Artisan Chocolate Talasi Watu Cacao – Origin Jembrana, Bali',
                'slug' => Str::slug('Artisan Chocolate Talasi Watu Cacao – Origin Jembrana, Bali'),
                'description' => 'Watu Talasi Finest Cacao Origin Jembrana, Bali This product is grown in the quiet lands of Jembrana, Bali. Harvested by hand and crafted without compromise.',
                'picture' => 'img/products/' . Str::slug('Artisan Chocolate Talasi Watu Cacao – Origin Jembrana, Bali') . '.webp',
                'price' => 151200,
                'stock' => 100,
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Jute Bag Crafted from high-quality natural by Talasi',
                'slug' => Str::slug('Jute Bag Crafted from high-quality natural by Talasi'),
                'description' => 'Upgraded your everyday carry with Talasi Jute Bag. Crafted from high-quality natural jute, it’s lightweight and ideal for daily errands, work, or even weekend getaway.',
                'picture' => 'img/products/' . Str::slug('Jute Bag Crafted from high-quality natural by Talasi') . '.webp',
                'price' => 98000,
                'stock' => 100,
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Watu Coffee Arabica Origin Kintamani Koji Fermentation',
                'slug' => Str::slug('Watu Coffee Arabica Origin Kintamani Koji Fermentation'),
                'description' => 'Fully mature coffee cherries further taking a yeast fermentation process called Koji at our facility and in house roasting process at Talasi Bali. The medium roast profile brings out the bean’s unique characteristics such as light acidity.',
                'picture' => 'img/products/' . Str::slug('Watu Coffee Arabica Origin Kintamani Koji Fermentation') . '.webp',
                'price' => 122500,
                'stock' => 100,
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Arabica Roasted Coffee Bean Origin Bajawa',
                'slug' => Str::slug('Arabica Roasted Coffee Bean Origin Bajawa'),
                'description' => 'From the finest East Nusa Tenggara beans, fully matured coffee cherries undergo an in-house roasting process at Talasi Weetabula in Sumba. The medium roast profile brings out the beans unique characteristics, including light acidity, sweet citrus notes, and a reminiscence of jasmine flowers.',
                'picture' => 'img/products/' . Str::slug('Arabica Roasted Coffee Bean Origin Bajawa') . '.webp',
                'price' => 150000,
                'stock' => 100,
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
        \App\Models\Product::insert($products);
    }
}
