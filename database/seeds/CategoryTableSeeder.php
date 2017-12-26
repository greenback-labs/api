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
        factory(Category::class, rand(10, 50))->create()->each(function($recordCategory) {
            if(rand(1, 2) % 2 === 0 && ($id = CategoryTableSeeder::randomCategoryId([$recordCategory->id]))) {
                $recordCategory->category_id = $id;
                $recordCategory->save();
            }
        });
    }

    /**
     * Get an random category.
     *
     * @return int
     */
    public static function randomCategoryId(Array $except = [])
    {
        do {
            $id = rand(Category::min('id') ?: 0, Category::count());
        } while(in_array($id, $except));
        
        return $id ?: null;
    }
}
