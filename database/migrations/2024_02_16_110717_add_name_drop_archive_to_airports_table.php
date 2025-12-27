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
        Schema::table('airports', function (Blueprint $table) {

            $table->string('name')->nullable()->after('id');
            $table->dropColumn('archive_data');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('airports', function (Blueprint $table) {

            $table->text('archive_data')->nullable()->after('state_id');
            $table->dropColumn('name');

        });
    }
};
