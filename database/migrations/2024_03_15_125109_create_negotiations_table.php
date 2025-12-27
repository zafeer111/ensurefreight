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
        Schema::create('negotiations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('negotiable_id');
            $table->string('negotiable_type');
            $table->unsignedBigInteger('quotes_id');
            $table->decimal('new_rate');
            $table->unsignedTinyInteger('status')->default(1)->comment('1 = Pending, 2 = Confirmed, 3 = Rejected');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('negotiations');
    }
};
