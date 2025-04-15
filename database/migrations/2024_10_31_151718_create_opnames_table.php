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
        Schema::create('opnames', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('itemID', 8);
            $table->date('opnameDate');
            $table->integer('systemStock')->unsigned();
            $table->integer('physicalStock')->unsigned();
            $table->integer('difference');
            $table->text('remarks')->nullable();
            $table->foreign('itemID')->references('id')->on('items');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('opnames');
    }
};
