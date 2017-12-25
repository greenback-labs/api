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
        factory(Account::class, rand(6, 20))->create()->each(function($recordAccount) {
            if(rand(1, 2) % 2 === 0 && ($id = $this->randomAccountId([$recordAccount->id]))) {
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
    private function randomAccountId(Array $except = [])
    {
        do {
            $id = rand(Account::min('id') ?: 0, Account::count());
        } while(in_array($id, $except));
        
        return Account::find($id) ?: null;
    }
}
