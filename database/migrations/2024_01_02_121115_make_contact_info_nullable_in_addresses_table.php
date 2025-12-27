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
        Schema::table('addresses', function (Blueprint $table) {
            $table->string('contact_name')->nullable()->change();
            $table->string('contact_email')->nullable()->change();
            $table->string('phone_number')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('addresses', function (Blueprint $table) {
            $table->string('contact_name')->nullable(false)->change();
            $table->string('contact_email')->nullable(false)->change();
            $table->string('phone_number')->nullable(false)->change();
        });
    }
};
