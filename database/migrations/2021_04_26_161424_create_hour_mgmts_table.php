<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHourMgmtsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hour_mgmts', function (Blueprint $table) {
            $table->id();
            $table->string('codeHourMgmt', 20);
            $table->foreignId('codeEmployee')->constrained('employees');
            $table->boolean('validatedHourMgmt');
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
        Schema::dropIfExists('hour_mgmts');
    }
}
