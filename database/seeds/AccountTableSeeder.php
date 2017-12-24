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
        $recordsAccount = factory(Account::class, rand(6, 20))->create();
        
        foreach($recordsAccount as $recordAccount) {
            if(rand(1, 2) % 2 === 0 && ($id = rand(1, Account::count())) !== $recordAccount->id) {
                $recordAccount->account_id = $id;
            }
        }
    }
}
