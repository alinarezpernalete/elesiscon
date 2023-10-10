<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            
            $table->string('codeArticle', 12);
            $table->string('nameArticle', 50);
            $table->string('modelArticle', 50)->nullable();
            $table->string('referenceArticle', 50)->nullable();
            $table->decimal('weightArticle', 8, 2)->nullable();
            $table->string('locationArticle', 12)->nullable();
            //------------------------------------------//
            $table->foreignId('lineArticle')->constrained('lines');
            $table->foreignId('sublineArticle')->constrained('sublines');
            $table->foreignId('groupArticle')->constrained('groups');
            $table->foreignId('originArticle')->constrained('origins');
            $table->foreignId('typeArticle')->constrained('types');
            $table->foreignId('providerArticle')->constrained('providers');
            $table->boolean('statusArticle');

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
        Schema::dropIfExists('articles');
    }
}
