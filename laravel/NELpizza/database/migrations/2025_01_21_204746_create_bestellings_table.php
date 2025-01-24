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

        Schema::create('bestellings', function (Blueprint $table) {
            $table->id();
            $table->timestamp('datum');
            $table->enum('status', ["besteld","bereiden","inoven","uitoven","onderweg","bezorgd","geannuleerd"]);
            $table->foreignId('klant_id')->constrained();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bestellings');
    }
};
