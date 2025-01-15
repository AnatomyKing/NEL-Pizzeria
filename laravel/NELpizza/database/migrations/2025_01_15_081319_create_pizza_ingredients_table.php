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
        Schema::create('pizza_ingredients', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pizza_id');
            $table->unsignedBigInteger('ingredient_id');
            $table->timestamps();

            // Foreign keys
            $table->foreign('pizza_id')
                ->references('id')
                ->on('pizzas')
                ->onDelete('cascade');

            $table->foreign('ingredient_id')
                ->references('id')
                ->on('ingredients')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pizza_ingredients');
    }
};
