<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaleDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_details', function (Blueprint $table) {
            $table->id();

            $table->foreignId('codeSale')->nullable()->constrained('sales');
            $table->foreignId('codeArticle')->constrained('articles');
            $table->integer('amountArticle');
            $table->integer('pendingAmountArticle')->nullable();
            $table->decimal('unitPriceArticle', 8, 2);
            $table->boolean('quoSale');
            $table->boolean('SOSale')->nullable();
            $table->boolean('delNoteSale')->nullable();
            $table->boolean('billSale')->nullable();
            $table->boolean('cancelSale')->nullable();

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
        Schema::dropIfExists('sale_details');
    }
}
