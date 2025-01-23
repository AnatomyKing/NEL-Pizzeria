<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('naam');
            $table->string('functie')->nullable();    // Toegevoegd
            $table->string('email')->unique();
            $table->string('adres')->nullable();
            $table->string('woonplaats')->nullable();
            $table->string('telefoon')->nullable();   // Toegevoegd
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('employees');
    }
}
