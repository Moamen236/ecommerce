<?php

namespace Database\Seeders;

use League\Csv\Reader;
use App\Models\SubCategory;
use Illuminate\Support\Str;
use App\Models\SubSubCategory;
use Illuminate\Database\Seeder;
use Rap2hpoutre\FastExcel\FastExcel;

class SubSubCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $records = (new FastExcel)->import(__DIR__ . '/data/sub_sub_categories.xlsx');
        $csv = Reader::createFromPath(__DIR__ . '/data/sub_sub_categories.csv', 'r');
        $csv->setHeaderOffset(0);
        $records = $csv->getRecords();

        foreach ($records as $record) {
            SubSubCategory::create([
                'name_en' => $record['name_en'],
                'name_ar' => $record['name_ar'],
                'description_en' => $record['description_en'],
                'description_ar' => $record['description_ar'],
                'slug' => Str::slug($record['name_en']),
                'sub_category_id' => SubCategory::all()->random()->id
            ]);
        }
    }
}
