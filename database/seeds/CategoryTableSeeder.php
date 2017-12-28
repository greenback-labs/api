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
            $except = CategoryTableSeeder::getRecursiveRecordsId($recordCategory);
            array_push($except, $recordCategory->id);
            
            if(rand(1, 2) % 2 === 0 && ($id = CategoryTableSeeder::randomCategoryId($except))) {
                $recordCategory->category_id = $id;
                $recordCategory->save();
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
     * Get an array containing the category id of recursive records.
     *
     * @param  \App\Category  $recordCategory
     * @return array
     */
    public static function getRecursiveRecordsId(Category $recordCategory)
    {
        $recursiveRecordsId = [];
        $currentCategory = $recordCategory;
        
        while($currentCategory = $currentCategory->recordCategory) {
            array_push($recursiveRecordsId, $currentCategory->id);
        }

        return $recursiveRecordsId;
    }
}
