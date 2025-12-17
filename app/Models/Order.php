<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'customer_id',
        'supplier_id',
        'business_id',
        'customer_name',
        'customer_phone',
        'delivery_address',
        'delivery_region',
        'special_instructions',
        'payment_method',
        'subtotal_amount',
        'delivery_fee',
        'total_amount',
        'status',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'subtotal_amount' => 'decimal:2',
        'delivery_fee' => 'decimal:2',
        'total_amount' => 'decimal:2',
    ];

    /**
     * Get the customer (user) who placed the order.
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    /**
     * Get the business that received the order.
     */
    public function business(): BelongsTo
    {
        return $this->belongsTo(Supplier::class, 'business_id');
    }

    /**
     * Get the order items (the cart contents) for the order.
     */
    public function items(): HasMany
    {
        // order_items.order_id relates to orders.id
        return $this->hasMany(OrderItem::class);
    }



    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

}

