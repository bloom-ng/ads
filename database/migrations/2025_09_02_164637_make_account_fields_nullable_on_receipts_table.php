<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeAccountFieldsNullableOnReceiptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('receipts', function (Blueprint $table) {
            $table->string('account_name')->nullable()->change();
            $table->bigInteger('account_number')->nullable()->change();
            $table->string('bank_name')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('receipts', function (Blueprint $table) {
            $table->string('account_name')->change();
            $table->bigInteger('account_number')->change();
            $table->string('bank_name')->change();
        });
    }
}
