<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id'); // Primary key
            $table->dateTime('bestelling_datum'); // Order date
            $table->string('status', 50); // Status of the order
            $table->unsignedBigInteger('klant_id'); // Foreign key

            // Define the foreign key relationship
            $table->foreign('klant_id')
                  ->references('id')
                  ->on('klants')
                  ->onDelete('cascade');

            $table->timestamps(); // Adds created_at and updated_at columns
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}

