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
                $except = AccountTableSeeder::getChildAccountRecordsId($recordAccount);
                array_push($except, $recordAccount->id);

                if(($id = AccountTableSeeder::randomAccountId($except))) {
                    $recordAccount->account_id = $id;
                    $recordAccount->save();
                }
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
     * Get an array containing the account id of recursive child records of the received account record.
     *
     * @param  \App\Account  $recordAccount
     * @return array
     */
    public static function getChildAccountRecordsId(Account $recordAccount)
    {
        $recordsAccountId = [];
        
        foreach($recordAccount->recordsAccount as $currentRecordAccount) {
            array_merge($recordsAccountId, AccountTableSeeder::getChildAccountRecordsId($currentRecordAccount);
        }

        return $recordsAccountId;
    }
}
