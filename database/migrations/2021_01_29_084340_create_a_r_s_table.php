<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateARSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('a_r_s', function (Blueprint $table) {
            $table->id();
            $table->foreignId('codeSale')->constrained('sales');
            $table->string('codeAR', 12)->nullable();
            $table->foreignId('codeARType')->constrained('a_r_types');
            $table->foreignId('codeCustomer')->constrained('customers');
            $table->foreignId('codePayment')->constrained('payment_conditions');
            $table->foreignId('codeCurrency')->constrained('currencies')->nullable();
            $table->foreignId('codeBank')->constrained('banks')->nullable();
            $table->decimal('amountDocument', 12, 2);
            $table->decimal('amountAR', 12, 2)->nullable();
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
        Schema::dropIfExists('a_r_s');
    }
}
