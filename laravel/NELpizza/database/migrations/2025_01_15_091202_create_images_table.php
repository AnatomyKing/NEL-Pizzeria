<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('pizza_id');
            $table->mediumBlob('data'); // Store the binary image data
            $table->string('mime_type'); // Store the MIME type (e.g., image/jpeg)
            $table->timestamps();
    
            $table->foreign('pizza_id')->references('id')->on('pizzas')->onDelete('cascade');
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('images');
    }
};
