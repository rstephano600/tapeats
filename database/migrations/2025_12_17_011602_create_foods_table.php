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
        Schema::create('foods', function (Blueprint $table) {
            $table->id();

            // Relations
            $table->unsignedBigInteger('supplier_id');   // The supplier (user ID)
            $table->unsignedBigInteger('business_id');   // The specific business (supplier ID)

            // Food details
            $table->string('food_name');
            $table->string('category')->nullable();      // rice, drinks, fast food, etc.
            $table->decimal('price', 10, 2);
            $table->string('image')->nullable();         // image file path
            $table->boolean('available')->default(true); // toggle availability
            $table->text('description')->nullable();

            $table->timestamps();

            // Foreign keys
            // Note: If you want to link supplier_id to users table (ID), change `on('suppliers')`
            $table->foreign('supplier_id')->references('user_id')->on('suppliers')->onDelete('cascade');
            $table->foreign('business_id')->references('id')->on('suppliers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('foods');
    }
};