<?php

namespace Database\Seeders;

use App\Models\Shop;
use App\Models\User;
use Illuminate\Database\Seeder;

class ShopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $shop = Shop::create([
            'name' => 'Test Shop',
        ]);

        User::create([
            'shop_id' => $shop->id,
            'name' => 'Test shop user',
            'email' => 'shop1@gmail.com',
            'email_verified_at' => now(),
            'two_factor_verified_at' => now(),
            'password' => bcrypt('12345678'),
        ]);
    }
}
