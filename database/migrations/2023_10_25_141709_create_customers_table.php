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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->unsignedSmallInteger('type')->default(0)->comment('0: company, 1: individuals');
            $table->string('name');
            $table->text('address')->nullable();
            $table->unsignedBigInteger('city_id')->nullable();
            $table->unsignedBigInteger('country_id')->nullable();
            $table->unsignedBigInteger('state_id')->nullable();
            $table->unsignedBigInteger('airport_id')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('phone')->nullable();
            $table->string('alternate_phone_no')->nullable();
            $table->string('fax')->nullable();
            $table->string('cell_no')->nullable();
            $table->string('email')->nullable();
            $table->string('account_no')->nullable();
            $table->string('contact_person')->nullable();
            $table->string('domain')->nullable();
            $table->uuid('customer_uuid')->unique();
            $table->text('archive_data')->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
