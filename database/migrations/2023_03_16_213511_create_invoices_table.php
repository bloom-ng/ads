<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->float('vat')->default(7.5);
            $table->float('service_charge');
            $table->dateTime('date');
            $table->string('billed_to_line_1');
            $table->string('billed_to_line_2');
            $table->string('billed_to_line_3');
            $table->string('account_name');
            $table->bigInteger('account_number');
            $table->string('bank_name');
            $table->text('line_items');
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
        Schema::dropIfExists('invoices');
    }
}
