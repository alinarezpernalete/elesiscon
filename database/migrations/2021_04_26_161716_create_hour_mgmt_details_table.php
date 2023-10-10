<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHourMgmtDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hour_mgmt_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('codeHourMgmt')->nullable()->constrained('hour_mgmts');
            $table->foreignId('codeEmployee')->constrained('employees');
            $table->foreignId('codeProject')->constrained('projects');
            $table->foreignId('codeActivity')->constrained('activities');
            $table->integer('hrsHourMgmt');
            $table->date('dateHourMgmt', 50);
            $table->string('descriptionHourMgmt', 180);
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
        Schema::dropIfExists('hour_mgmt_details');
    }
}
