<?php

namespace Database\Seeders;

use App\Models\DeliveryFee;
use Illuminate\Database\Seeder;

class DeliveryFeeSeeder extends Seeder
{
    public function run(): void
    {
        $states = [
            'Abia', 'Adamawa', 'Akwa Ibom', 'Anambra', 'Bauchi', 'Bayelsa',
            'Benue', 'Borno', 'Cross River', 'Delta', 'Ebonyi', 'Edo',
            'Ekiti', 'Enugu', 'FCT', 'Gombe', 'Imo', 'Jigawa',
            'Kaduna', 'Kano', 'Katsina', 'Kebbi', 'Kogi', 'Kwara',
            'Lagos', 'Nasarawa', 'Niger', 'Ogun', 'Ondo', 'Osun',
            'Oyo', 'Plateau', 'Rivers', 'Sokoto', 'Taraba', 'Yobe', 'Zamfara',
        ];

        foreach ($states as $state) {
            DeliveryFee::updateOrCreate(
                ['state' => $state],
                ['fee' => 2000.00, 'is_active' => true]
            );
        }
    }
}
