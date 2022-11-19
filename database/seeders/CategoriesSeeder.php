<?php

namespace Database\Seeders;

use League\Csv\Reader;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Rap2hpoutre\FastExcel\FastExcel;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $records = (new FastExcel)->import(__DIR__ . '/data/categories.xlsx');
        $csv = Reader::createFromPath(__DIR__ . '/data/categories.csv', 'r');
        $csv->setHeaderOffset(0);
        $records = $csv->getRecords();

        foreach ($records as $record) {
            Category::create([
                'name_en' => $record['name_en'],
                'name_ar' => $record['name_ar'],
                'description_en' => $record['description_en'],
                'description_ar' => $record['description_ar'],
                'slug' => Str::slug($record['name_en']),
            ]);
        }
    }
}
