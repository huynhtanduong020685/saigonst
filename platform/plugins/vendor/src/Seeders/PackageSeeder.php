<?php

namespace Botble\Vendor\Seeders;

use Botble\Vendor\Models\Package;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    public function run()
    {
        Package::truncate();

        $data = [
            [
                'name'               => 'Free',
                'price'              => 0,
                'currency_id'        => 1,
                'order'              => 0,
                'number_of_days'     => 10,
                'number_of_listings' => 5,
                'is_default'         => true,
            ],
            [
                'name'               => 'Basic',
                'price'              => 9.99,
                'currency_id'        => 1,
                'order'              => 0,
                'number_of_days'     => 30,
                'number_of_listings' => 10,
                'is_default'         => false,
            ],
            [
                'name'               => 'Premium',
                'price'              => 19.99,
                'currency_id'        => 1,
                'order'              => 2,
                'number_of_days'     => 90,
                'number_of_listings' => 30,
                'is_default'         => false,
            ],
        ];

        foreach ($data as $item) {
            Package::create($item);
        }
    }
}
