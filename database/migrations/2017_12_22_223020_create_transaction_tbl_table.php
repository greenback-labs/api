<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionTblTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_tbl', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('account_id')->unsigned();
            $table->integer('category_id')->unsigned();
            $table->integer('person_id')->unsigned()->nullable();
            $table->integer('transfer_code')->unsigned()->nullable();
            $table->string('type');
            $table->decimal('value', 12, 2);
            $table->string('title', 250);
            $table->string('description', 1000)->nullable();
            $table->timestamp('date')->useCurrent();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();

            $table->foreign('account_id')->references('id')->on('account_tbl');
            $table->foreign('category_id')->references('id')->on('category_tbl');
            $table->foreign('person_id')->references('id')->on('person_tbl');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaction_tbl');
    }
}
