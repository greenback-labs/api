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
            $except = AccountTableSeeder::getRecursiveRecordsId($recordAccount);
            array_push($except, $recordAccount->id);
            
            if(rand(1, 2) % 2 === 0 && ($id = AccountTableSeeder::randomAccountId($except))) {
                $recordAccount->account_id = $id;
                $recordAccount->save();
            }
        });
    }

    /**
     * Get an random account id.
     *
     * @param  array  $except
     * @return int
     */
    public static function randomAccountId(array $except = [])
    {
        do {
            $id = rand(Account::min('id') ?: 0, Account::count());
        } while(in_array($id, $except));
        
        return $id ?: null;
    }

    /**
     * Get an array containing the account id of recursive records (parent and child merged).
     *
     * @param  \App\Account  $recordAccount
     * @return array
     */
    public static function getRecursiveRecordsId(Account $recordAccount)
    {
        $parentRecordsId = [];
        $currentAccount = $recordAccount;
        
        while($currentAccount = $currentAccount->recordAccountParent) {
            array_push($parentRecordsId, $currentAccount->id);
        }

        $childRecordsId = [];
        $currentAccount = $recordAccount;

        while($currentAccount = $currentAccount->recordAccountChild) {
            array_push($childRecordsId, $currentAccount->id);
        }

        return array_merge($parentRecordsId, $childRecordsId);
    }
}
