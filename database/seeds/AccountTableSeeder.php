<?php

use Illuminate\Database\Seeder;
use App\Account;

class AccountTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $minRecords = 6;
        $maxRecords = 20;

        factory(Account::class, rand($minRecords, $maxRecords))->create()->each(function($recordAccount) {
            if(rand(1, 2) % 2 === 0 && ($id = AccountTableSeeder::randomAccountId([$recordAccount->id]))) {
                $recordAccount->account_id = $id;
                $recordAccount->save();
            }
        });
    }

    /**
     * Get an random account.
     *
     * @return int
     */
    public static function randomAccountId(Array $except = [])
    {
        do {
            $id = rand(Account::min('id') ?: 0, Account::count());
        } while(in_array($id, $except));
        
        return $id ?: null;
    }
}
