<?php

use Illuminate\Database\Seeder;
use App\Account;
use App\Category;
use App\Person;
use App\Transaction;


class TransactionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(Account::count() === 0 || Category::count() === 0) {
            return;
        }

        $initialYear = 2015;
        $finalYear = 2018;

        $minPerMonth = 10;
        $maxPerMonth = 50;

        $minPercentageTransferPerMonth = 0;
        $maxPercentageTransferPerMonth = 20;

        $recordsTransaction = collect();
        $currentYear = $initialYear;

        while($currentYear <= $finalYear) {
            for($i = 1; $i <= 12; $i++) {
                $transactionQuantity = rand($minPerMonth, $maxPerMonth);
                $transferPercentage = round($transactionQuantity * rand($minPercentageTransferPerMonth, $maxPercentageTransferPerMonth));
                $transferQuantity = $transferPercentage % 2 === 0 ? $transferPercentage : $transferPercentage - 1;
                $transactionQuantity -= $transferQuantity;

                $recordsTransaction->union(factory(Transaction::class, $transactionQuantity)->create()->each(function($recordTransaction) {
                    $recordTransaction = changeTransaction($recordTransaction, [
                        'currentMonth' => $i,
                        'currentYear' => $currentYear
                    ]);
                })));

                factory(Transaction::class, ($transferQuantity / 2))->create([
                    'type' => 'out'
                ])->each(function($recordTransaction) {
                    $recordTransaction->transfer_code = (Transaction::max('transfer_code') ?: 0) + 1;

                    $recordTransaction = changeTransaction($recordTransaction, [
                        'currentMonth' => $i,
                        'currentYear' => $currentYear
                    ]);

                    $recordTransaction->save();

                    $recordTransactionReplicated = $recordTransaction->replicate();
                    $recordTransactionReplicated->type = 'in';
                    $recordTransactionReplicated->save();

                    $recordsTransaction->union(collect($recordTransaction, $recordTransactionReplicated));

                })));
            }
            $currentYear += 1;
        }
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
        
        return $id ?: null;
    }

    /**
     * Get an random category.
     *
     * @return int
     */
    private function randomCategoryId(Array $except = [])
    {
        do {
            $id = rand(Category::min('id') ?: 0, Category::count());
        } while(in_array($id, $except));
        
        return $id ?: null;
    }

    /**
     * Get an random person.
     *
     * @return int
     */
    private function randomPersonId(Array $except = [])
    {
        do {
            $id = rand(Person::min('id') ?: 0, Person::count());
        } while(in_array($id, $except));
        
        return $id ?: null;
    }

    /**
     * Get an random date.
     *
     * @return int
     */
    private function randomDate(int $currentMonth, int $currentYear)
    {
        $initialDate = mktime(0, 0, 0, $currentMonth, 1, $currentYear);
        $finalDate = mktime(0, 0, 0, $currentMonth, date('t', $initialDate), $currentYear);
        
        return rand($initialDate, $finalDate);
    }

    /**
     * Change some attributes of a transaction record and returns the modified record.
     *
     * @return Transaction
     */
    public function changeTransaction(Transaction $recordTransaction, Array $date)
    {
        $recordTransaction->date = $this->randomDate($date['currentMonth'], $date['currentYear']);
        $recordTransaction->account_id = $this->randomAccountId();
        $recordTransaction->category_id = $this->randomCategoryId();
        $recordTransaction->person_id = !$recordTransaction->transfer_code && rand(1, 2) % 2 === 0 ? $this->randomPersonId() : null;

        return $recordTransaction;
    }
}
