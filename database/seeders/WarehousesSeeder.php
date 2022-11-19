<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Warehouse;
use Illuminate\Database\Seeder;

class WarehousesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $warehouse = Warehouse::create([
            'name_en' => "6 October",
            'name_ar' => "6 اكتوبر",
            'location_en' => "6 October",
            'location_ar' => "6 اكتوبر",
            'shipping_price' => 20,
        ]);

        // add admins to the warehouse
        $admins = Admin::all();
        foreach ($admins as $admin) {
            $admin->warehouses()->sync([$warehouse->id]);
        }
    }
}
