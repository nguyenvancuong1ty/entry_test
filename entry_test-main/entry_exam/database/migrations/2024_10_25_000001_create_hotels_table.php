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
        Schema::create('hotels', function (Blueprint $table) {
            $table->unsignedBigInteger('hotel_id')->autoIncrement();
            $table->string('hotel_name')->comment('hotel name');
            $table->unsignedInteger('prefecture_id')->comment('prefecture');
            $table->text('file_path')->nullable()->comment('display at list page');
            $table->timestamps();
            $table->foreign('prefecture_id')->references('prefecture_id')->on('prefectures');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hotels');
    }
};
