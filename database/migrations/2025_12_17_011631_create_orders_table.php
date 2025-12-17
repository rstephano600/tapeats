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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            // Core Relations
            $table->unsignedBigInteger('customer_id');   // user placing the order
            $table->unsignedBigInteger('supplier_id');   // food supplier (user ID)
            $table->unsignedBigInteger('business_id');   // specific canteen (supplier ID)

            // Delivery & Customer Info (from checkout form)
            $table->string('customer_name');
            $table->string('customer_phone');
            $table->text('delivery_address');
            $table->string('delivery_region');
            $table->text('special_instructions')->nullable();
            
            // Financials
            $table->decimal('subtotal_amount', 10, 2)->default(0); 
            $table->decimal('delivery_fee', 10, 2)->default(0); 
            $table->decimal('total_amount', 10, 2)->default(0);

            // Status & Payment
            $table->enum('payment_method', ['cash', 'mobile_money'])->default('cash');
            $table->enum('status', [
                'pending', 
                'accepted', 
                'preparing', 
                'ready', 
                'out_for_delivery',
                'completed',
                'cancelled'
            ])->default('pending');

            $table->timestamps();

            // Foreign keys
            $table->foreign('customer_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('supplier_id')->references('user_id')->on('suppliers')->onDelete('cascade');
            $table->foreign('business_id')->references('id')->on('suppliers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};