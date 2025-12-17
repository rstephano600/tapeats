<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Food extends Model
{
    use HasFactory;
    protected $table = 'foods';
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'supplier_id',
        'business_id',
        'food_name',
        'category',
        'price',
        'image',
        'available',
        'description',
    ];
    
    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'price' => 'decimal:2',
        'available' => 'boolean',
    ];

    /**
     * Get the business that offers this food item.
     */
    public function business(): BelongsTo
    {
        // foods.business_id relates to suppliers.id
        return $this->belongsTo(Supplier::class, 'business_id');
    }

    /**
     * Get all the order items that include this food.
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function supplierBusiness()
    {
        return $this->belongsTo(Supplier::class, 'business_id');
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'supplier_id');
    }

    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/'.$this->image) : asset('images/default-food.png');
    }
    public function supplier()
{
    return $this->belongsTo(Supplier::class);
}

}