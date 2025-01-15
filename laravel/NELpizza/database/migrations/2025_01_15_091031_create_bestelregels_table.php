<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('bestelregels', function (Blueprint $table) {
            $table->id();
            $table->integer('aantal');
            $table->enum('afmeting', ["klein","normaal","groot"]);
            $table->foreignId('pizza_id')->constrained();
            $table->foreignId('bestelling_id')->constrained();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bestelregels');
    }
};
