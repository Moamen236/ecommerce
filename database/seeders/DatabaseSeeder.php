<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Admin;
use App\Models\District;
use App\Models\Location;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $superRole = Role::create(['name' => 'super', 'guard_name' => 'admin']);

        error_log('Add Admin ...');
        $admin = Admin::create([
            'first_name' => 'Moamen',
            'last_name' => 'Ali',
            'email' => 'mo@mail.com',
            'password' => Hash::make('mo123456'),
        ]);
        $admin->syncRoles($superRole);
        error_log('Admin done ...');

        error_log('Brands start ...');
        $this->call([BrandsSeeder::class]);
        error_log('Brands done ...');

        error_log('Categories start ...');
        $this->call([CategoriesSeeder::class]);
        error_log('Categories done ...');

        error_log('SubCategories start ...');
        $this->call([SubCategoriesSeeder::class]);
        error_log('SubCategories done ...');

        error_log('SubSubCategories start ...');
        $this->call([SubSubCategoriesSeeder::class]);
        error_log('SubSubCategories done ...');
        
        error_log('Warehouses start ...');
        $this->call([WarehousesSeeder::class]);
        error_log('Warehouses done ...');

        error_log('Products start ...');
        $this->call([ProductsSeeder::class]);
        error_log('Products done ...');
    }
}
