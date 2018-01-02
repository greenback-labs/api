<?php

use Illuminate\Database\Seeder;
use App\Category;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $minRecords = 10;
        $maxRecords = 50;

        factory(Category::class, rand($minRecords, $maxRecords))->create()->each(function($recordCategory) {
            if(rand(1, 2) % 2 === 0) {
                $except = CategoryTableSeeder::getChildCategoryRecordsId($recordCategory);
                array_push($except, $recordCategory->id);

                if(($id = CategoryTableSeeder::randomCategoryId($except))) {
                    $recordCategory->category_id = $id;
                    $recordCategory->save();
                }
            }
        });
    }

    /**
     * Get an random category id.
     *
     * @param  array  $except
     * @return int
     */
    public static function randomCategoryId(array $except = [])
    {
        do {
            $id = rand(Category::min('id') ?: 0, Category::count());
        } while(in_array($id, $except));
        
        return $id ?: null;
    }

    /**
     * Get an array containing the category id of recursive child records of the received category record.
     *
     * @param  \App\Category  $recordCategory
     * @return array
     */
    public static function getChildCategoryRecordsId(Category $recordCategory)
    {
        $recordsCategoryId = [];
        
        foreach($recordCategory->recordsCategory as $currentRecordCategory) {
            array_push($recordsCategoryId, $currentRecordCategory->id);
            array_merge($recordsCategoryId, CategoryTableSeeder::getChildCategoryRecordsId($currentRecordCategory);
        }

        return $recordsCategoryId;
    }
}
