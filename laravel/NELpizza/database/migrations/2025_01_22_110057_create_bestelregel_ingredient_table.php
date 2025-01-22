<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('bestelregel_ingredient', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bestelregel_id')->constrained('bestelregels')->onDelete('cascade');
            $table->foreignId('ingredient_id')->constrained('ingredients')->onDelete('cascade');
            $table->integer('quantity')->default(1);
        });
    }

    public function down()
    {
        Schema::dropIfExists('bestelregel_ingredient');
    }
};
