<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAPSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('a_p_s', function (Blueprint $table) {
            $table->id();
            $table->foreignId('codePurchase')->constrained('purchases');
            $table->string('codeAP', 12)->nullable();
            $table->foreignId('codeAPType')->constrained('a_p_types');
            $table->foreignId('codeProvider')->constrained('providers');
            $table->foreignId('codePayment')->constrained('payment_conditions');
            $table->foreignId('codeCurrency')->constrained('currencies')->nullable();
            $table->foreignId('codeBank')->constrained('banks')->nullable();
            $table->decimal('amountDocument', 12, 2);
            $table->decimal('amountAP', 12, 2)->nullable();
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
        Schema::dropIfExists('a_p_s');
    }
}
