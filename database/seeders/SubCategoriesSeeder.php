<?php

namespace Database\Seeders;

use League\Csv\Reader;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Rap2hpoutre\FastExcel\FastExcel;

class SubCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $records = (new FastExcel)->import(__DIR__ . '/data/sub_categories.xlsx');
        $csv = Reader::createFromPath(__DIR__ . '/data/sub_categories.csv', 'r');
        $csv->setHeaderOffset(0);
        $records = $csv->getRecords();

        foreach ($records as $record) {
            SubCategory::create([
                'name_en' => $record['name_en'],
                'name_ar' => $record['name_ar'],
                'description_en' => $record['description_en'],
                'description_ar' => $record['description_ar'],
                'slug' => Str::slug($record['name_en']),
                'category_id' => Category::all()->random()->id
            ]);
        }
    }
}
