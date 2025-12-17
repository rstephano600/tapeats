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
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();

            // The user who owns this business/canteen
            $table->unsignedBigInteger('user_id'); 

            $table->string('business_name');
            $table->string('business_type')->nullable(); // company, group, individual
            $table->string('phone_number')->nullable();
            $table->string('address')->nullable();
            $table->string('region')->nullable();
            $table->string('logo')->nullable();
            $table->text('description')->nullable();

            $table->boolean('is_verified')->default(false);

            $table->timestamps();

            // Foreign key to link the supplier business to a user account
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};