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
        Schema::create('airline_tariffs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('carriers_id');
            $table->unsignedInteger('type')->comment('1: GCR, 2: DGR PAX, ...');
            $table->date('valid_at');
            $table->date('expire_at');
            $table->decimal('cad_usd_conversion_rate');
            $table->decimal('airbable_fee')->default(0);
            $table->string('airbable_fee_currency')->comment('CAD');
            $table->decimal('surcharge')->default(0);
            $table->string('surcharge_currency')->comment('CAD');
            $table->decimal('custom_charges');
            $table->string('custom_charges_currency')->default('USD');
            $table->double('max_height')->comment('Max height in inches 125');
            $table->double('max_width')->comment('Max width in inches 96');
            $table->double('max_length')->comment('Max length in inches 63');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('airline_tariffs');
    }
};
