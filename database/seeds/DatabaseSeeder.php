<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AccountTableSeeder::class);
        $this->call(CategoryTableSeeder::class);
        $this->call(PersonTableSeeder::class);
        $this->call(TransactionTableSeeder::class);
        $this->call(InstallmentTableSeeder::class);
    }
}
