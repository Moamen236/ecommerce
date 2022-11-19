<?php

namespace Database\Seeders;

use Faker\Factory;
use App\Models\Brand;
use League\Csv\Reader;
use App\Models\Product;
use App\Models\Warehouse;
use Illuminate\Support\Str;
use App\Models\SubSubCategory;
use Illuminate\Database\Seeder;
use Rap2hpoutre\FastExcel\FastExcel;
use Spatie\MediaLibrary\Exceptions\FileCannotBeAdded\UnreachableUrl;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $records = (new FastExcel)->import(__DIR__ . '/data/products.xlsx');
        $csv = Reader::createFromPath(__DIR__ . '/data/products.csv', 'r');
        $csv->setHeaderOffset(0);
        $records = $csv->getRecords();
        $faker = Factory::create();

        foreach ($records as $record) {
            $product = Product::create([
                'name_en' => $record['name_en'],
                'name_ar' => $record['name_ar'],
                'short_description_en' => $record['short_description_en'],
                'short_description_ar' => $record['short_description_ar'],
                'description_en' => $record['description_en'],
                'description_ar' => $record['description_ar'],
                'sku' => $faker->numberBetween(1000000000, 9999999999),
                'price' => $faker->numberBetween(50, 10000),
                'final_price' => $faker->numberBetween(50, 10000),
                'total_quantity' => $faker->numberBetween(0, 100),
                'min_sale_quantity' => 1,
                'expiry_alarm_before' => 30,
                'brand_id' => Brand::all()->random()->id
            ]);
            $product->addSlugAttribute();

            try {
                $product->addMedia(__DIR__ . '/data'. $record['image_url'])->toMediaCollection('product.images');
                $image_url_media = $product->images->first();
                $product->image_url = $image_url_media->getUrl('card');
                $product->save();

                // $product->categories()->attach(SubSubCategory::all()->random()->id);
                
            } catch (UnreachableUrl $th) {
                $product->delete();
            }

            $warehouse = Warehouse::first();
            if ($warehouse) {
                $warehouse->products()->attach($product, [
                    'base_quantity' => 50,
                    'reduced_quantity' => 50,
                    'cost' => 1,
                ]);
            }
        }
    }
}
