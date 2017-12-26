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

        $currentYear = $initialYear;

        while($currentYear <= $finalYear) {
            for($i = 1; $i <= 12; $i++) {
                $transactionQuantity = rand($minPerMonth, $maxPerMonth);
                $transferPercentage = round($transactionQuantity * (rand($minPercentageTransferPerMonth, $maxPercentageTransferPerMonth) / 100));
                $transferQuantity = $transferPercentage % 2 === 0 ? $transferPercentage : $transferPercentage - 1;
                $transactionQuantity -= $transferQuantity;

                $recordsTransaction = factory(Transaction::class, $transactionQuantity)->make();

                foreach($recordsTransaction as $recordTransaction) {
                    $recordTransaction = $this->changeTransaction($recordTransaction, [
                        'currentMonth' => $i,
                        'currentYear' => $currentYear
                    ]);

                    $recordTransaction->save();
                }

                $recordsTransaction = factory(Transaction::class, ($transferQuantity / 2))->make([
                    'type' => 'out'
                ]);

                foreach($recordsTransaction as $recordTransaction) {
                    $recordTransaction->transfer_code = (Transaction::max('transfer_code') ?: 0) + 1;

                    $recordTransaction = $this->changeTransaction($recordTransaction, [
                        'currentMonth' => $i,
                        'currentYear' => $currentYear
                    ]);

                    $recordTransaction->save();

                    $recordTransactionReplicated = $recordTransaction->replicate();
                    $recordTransactionReplicated->type = 'in';

                    $recordTransactionReplicated->save();
                }
            }
            $currentYear += 1;
        }
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
        $recordTransaction->date = date('Y-m-d H:i:s', $this->randomDate($date['currentMonth'], $date['currentYear']));
        $recordTransaction->account_id = AccountTableSeeder::randomAccountId();
        $recordTransaction->category_id = CategoryTableSeeder::randomCategoryId();
        $recordTransaction->person_id = !$recordTransaction->transfer_code && rand(1, 2) % 2 === 0 ? PersonTableSeeder::randomPersonId() : null;

        return $recordTransaction;
    }
}
