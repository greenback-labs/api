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
        $recordsCategory = factory(Category::class, rand(6, 20))->create();
        
        foreach($recordsCategory as $recordCategory) {
            if(rand(1, 2) % 2 === 0 && ($id = rand(1, Category::count())) !== $recordCategory->id) {
                $recordCategory->category_id = $id;
            }
        }
    }
}
