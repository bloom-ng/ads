<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBloomLeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bloom_leads', function (Blueprint $table) {
            $table->id();
            $table->string('flow_token')->unique();
            $table->string('phone_number')->nullable();
            $table->string('client_name')->nullable();
            $table->string('brand_name')->nullable();
            $table->string('industry')->nullable();
            $table->json('services')->nullable();
            $table->string('budget')->nullable();
            $table->text('goals')->nullable();
            $table->string('timeline')->nullable();
            $table->string('contact_method')->nullable();
            $table->string('status')->default('in_progress'); // in_progress, qualified, low_budget, not_ready, completed
            $table->string('tag')->nullable(); // Qualified Lead – Hot, Nurture List
            $table->json('raw_data')->nullable(); // Store complete flow data
            $table->timestamp('completed_at')->nullable();
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
        Schema::dropIfExists('bloom_leads');
    }
}
