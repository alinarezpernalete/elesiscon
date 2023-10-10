<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('codeEmployee', 50);
            $table->foreignId('codeUser')->nullable()->constrained('users');
            $table->string('firstNameEmployee', 250);
            $table->string('lastNameEmployee', 250);
            $table->string('genderEmployee', 250);
            $table->date('birthDateEmployee', 250);
            $table->foreignId('departmentEmployee')->nullable()->constrained('departments');
            $table->foreignId('jobEmployee')->nullable()->constrained('jobs');
            $table->string('phoneEmployee', 250);
            $table->date('joinDateEmployee', 250);
            $table->string('addressEmployee', 250);
            $table->string('additionalEmployee', 250);
            $table->boolean('statusEmployee');
            $table->string('reasonStatusEmployee', 250)->nullable();
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
        Schema::dropIfExists('employees');
    }
}
