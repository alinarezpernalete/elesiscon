<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_details', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('codePurchase')->nullable()->constrained('purchases');
            $table->foreignId('codeArticle')->constrained('articles');
            $table->integer('amountArticle');
            $table->integer('pendingAmountArticle')->nullable();
            $table->decimal('unitPriceArticle', 8, 2);
            $table->boolean('POPurchase');
            $table->boolean('recNotePurchase')->nullable();
            $table->boolean('invoicePurchase')->nullable();
            $table->boolean('cancelPurchase')->nullable();

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
        Schema::dropIfExists('purchase_details');
    }
}
