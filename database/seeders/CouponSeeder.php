<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Coupon;
use Illuminate\Support\Str;

class CouponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $coupons = [
            [
                'code' => 'SAVE10NOW',
                'type' => 'percentage',
                'value' => 10.00,
                'valid_from' => now()->subDays(5),
                'valid_to' => now()->addDays(30),
                'is_active' => true,
            ],
            [
                'code' => 'FLAT500OFF',
                'type' => 'fixed',
                'value' => 500.00,
                'valid_from' => now()->subDays(10),
                'valid_to' => now()->addDays(15),
                'is_active' => true,
            ],
            [
                'code' => 'SUMMER20',
                'type' => 'percentage',
                'value' => 20.00,
                'valid_from' => now()->subDays(20),
                'valid_to' => now()->subDays(5),
                'is_active' => false, // Expired
            ],
            [
                'code' => 'WELCOME100',
                'type' => 'fixed',
                'value' => 100.00,
                'valid_from' => now()->subDays(2),
                'valid_to' => now()->addDays(60),
                'is_active' => true,
            ],
            [
                'code' => 'DISCOUNT15',
                'type' => 'percentage',
                'value' => 15.00,
                'valid_from' => now()->subDays(30),
                'valid_to' => now()->subDays(10),
                'is_active' => false, // Expired
            ],
            [
                'code' => 'GET200OFF',
                'type' => 'fixed',
                'value' => 200.00,
                'valid_from' => now()->subDays(1),
                'valid_to' => now()->addDays(45),
                'is_active' => true,
            ],
            [
                'code' => 'SPRING25',
                'type' => 'percentage',
                'value' => 25.00,
                'valid_from' => now()->subDays(60),
                'valid_to' => now()->subDays(30),
                'is_active' => false, // Expired
            ],
            [
                'code' => 'SAVE50NOW',
                'type' => 'fixed',
                'value' => 50.00,
                'valid_from' => now()->subDays(7),
                'valid_to' => now()->addDays(20),
                'is_active' => true,
            ],
            [
                'code' => 'WINTER10',
                'type' => 'percentage',
                'value' => 10.00,
                'valid_from' => now()->subDays(90),
                'valid_to' => now()->subDays(60),
                'is_active' => false, // Expired
            ],
            [
                'code' => 'FREEBIE300',
                'type' => 'fixed',
                'value' => 300.00,
                'valid_from' => now()->subDays(3),
                'valid_to' => now()->addDays(90),
                'is_active' => true,
            ],
        ];

        foreach ($coupons as $coupon) {
            Coupon::create([
                'code' => $coupon['code'],
                'type' => $coupon['type'],
                'value' => $coupon['value'],
                'valid_from' => $coupon['valid_from'],
                'valid_to' => $coupon['valid_to'],
                'is_active' => $coupon['is_active'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
