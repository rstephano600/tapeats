<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Supplier extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     * Corresponds to the columns in the 'suppliers' table.
     */
    protected $fillable = [
        'user_id',
        'business_name',
        'business_type',
        'phone_number',
        'address',
        'region',
        'logo',
        'description',
        'is_verified',
    ];

    /**
     * Get the user (owner) that owns the supplier business.
     */
    public function owner(): BelongsTo
    {
        // supplier.user_id relates to users.id
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the foods offered by this supplier business.
     */
    public function foods(): HasMany
    {
        // foods.business_id relates to suppliers.id
        return $this->hasMany(Food::class, 'business_id');
    }

    /**
     * Get the orders received by this supplier business.
     */
    public function orders(): HasMany
    {
        // orders.business_id relates to suppliers.id
        return $this->hasMany(Order::class, 'business_id');
    }
     public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope: Only verified businesses
     */
    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }

    /**
     * Scope: Only unverified businesses
     */
    public function scopeUnverified($query)
    {
        return $query->where('is_verified', false);
    }

    /**
     * Accessor for business logo URL
     */
    public function getLogoUrlAttribute()
    {
        if (!$this->logo) {
            return asset('images/default-logo.png'); // fallback
        }
        return asset('storage/' . $this->logo);
    }


   
}

