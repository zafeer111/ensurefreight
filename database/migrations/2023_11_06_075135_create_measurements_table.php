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
        Schema::create('measurements', function (Blueprint $table) {
            $table->id();
            $table->double('weight')->comment('Weight will be in kilograms');
            $table->double('width');
            $table->double('height');
            $table->double('length');
            $table->unsignedTinyInteger('dimension_unit');
            $table->unsignedTinyInteger('weight_unit');
            $table->unsignedInteger('quantity')->comment('Quantity of the item');
            $table->unsignedBigInteger('measurementable_id');
            $table->string('measurementable_type');
            $table->timestamps();
            
            $table->index(['measurementable_id', 'measurementable_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('measurements');
    }
};
