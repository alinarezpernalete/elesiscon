<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();

            $table->string('codePurchase', 12);
            $table->foreignId('providerPurchase')->constrained('providers');
            $table->foreignId('paymentPurchase')->constrained('payment_conditions');
            $table->string('descriptionPurchase', 50);
            $table->foreignId('typePurchase')->constrained('purchase_types');
            $table->foreignId('userPurchase')->constrained('users');
            $table->timestamp('PODatePurchase')->nullable();
            $table->timestamp('recNoteDatePurchase')->nullable();
            $table->timestamp('invoiceDatePurchase')->nullable();
            $table->timestamp('cancelDatePurchase')->nullable();
        
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
        Schema::dropIfExists('purchases');
    }
}
