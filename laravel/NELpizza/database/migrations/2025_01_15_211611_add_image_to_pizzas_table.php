<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pizzas', function (Blueprint $table) {
            // Add other columns if necessary
        });

        // Add the MEDIUMBLOB column using a raw SQL statement
        DB::statement("ALTER TABLE pizzas ADD image MEDIUMBLOB");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pizzas', function (Blueprint $table) {
            // Drop the MEDIUMBLOB column
            $table->dropColumn('image');
        });
    }
};
