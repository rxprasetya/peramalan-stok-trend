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
        Schema::create('sales', function (Blueprint $table) {
            $table->uuid('id') -> primary();
            $table->string('itemID', 8);
            $table->date('saleDate');
            $table->integer('qtySold')->unsigned();
            $table->integer('sale')->unsigned();
            $table->integer('totalSold')->unsigned();
            $table->foreign('itemID')->references('id')->on('items');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
