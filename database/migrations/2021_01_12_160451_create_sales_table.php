<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();

            $table->string('codeSale', 12);
            $table->foreignId('customerSale')->constrained('customers');
            $table->foreignId('paymentSale')->constrained('payment_conditions');
            $table->string('descriptionSale', 50);
            $table->foreignId('typeSale')->constrained('sale_types');
            $table->foreignId('userSale')->constrained('users');
            $table->timestamp('quoDateSale')->nullable();
            $table->timestamp('SODateSale')->nullable();
            $table->timestamp('delNoteDateSale')->nullable();
            $table->timestamp('billDateSale')->nullable();
            $table->timestamp('cancelDateSale')->nullable();

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
        Schema::dropIfExists('sales');
    }
}
