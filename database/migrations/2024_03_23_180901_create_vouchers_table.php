<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVouchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->string("place");
            $table->string("expense_head");
            $table->string("month");
            $table->date('date');
            $table->string("beneficiary");
            $table->string("amount_words");
            $table->string("cash_cheque_no");
            $table->string("prepared_by");
            $table->string("examined_by");
            $table->string("authorized_for_payment");
            $table->date("date_prepared");
            $table->text('line_items');
            $table->string("currency")->default("₦");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vouchers');
    }
}
