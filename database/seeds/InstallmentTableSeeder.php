<?php

use Illuminate\Database\Seeder;
use App\Installment;
use App\Transaction;

class InstallmentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $minPerTransaction = 2;
        $maxPerTransaction = 12;

        foreach(Transaction::whereNull('transfer_code')->get() as $recordTransaction) {
            if(rand(1, 3) % 2 === 0 && $recordTransaction->value > 1) {
                $installmentQuantity = rand($minPerTransaction, $maxPerTransaction);
                $period = array_rand(['day', 'month', 'year']);
                $currentDate = $recordTransaction->date;
                $installmentValue = round($recordTransaction->value / $installmentQuantity, 2);
                $lastInstallmentValue = $installmentValue + ($recordTransaction->value - ($installmentValue * $installmentQuantity));
                $currentInstallment = 1;

                factory(Installment::class, $installmentQuantity)->create()->each(function($recordInstallment) {
                    $recordInstallment->transaction_id = $recordTransaction->id;
                    $recordInstallment->deadline_date = $currentDate;
                    $recordInstallment->effective_date = $currentDate;
                    $recordInstallment->value = $currentInstallment === $installmentQuantity ? $lastInstallmentValue : $installmentValue;

                    $currentDate = strtotime('+1 ' . $period, $currentDate);
                    $currentInstallment += 1;
                });
            }
        }
    }
}
