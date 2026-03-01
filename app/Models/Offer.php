<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Offer extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'type',
        'discount_type',
        'discount_value',
        'start_date',
        'end_date',
        'is_active',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'discount_value' => 'decimal:2',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'is_active' => 'boolean',
    ];

    /**
     * Get the products associated with the offer.
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'offer_products');
    }

    /**
     * Scope a query to only include active offers.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now());
    }

    /**
     * Scope a query to only include flash sale offers.
     */
    public function scopeFlashSale($query)
    {
        return $query->where('type', 'flash_sale');
    }

    /**
     * Check if offer is valid.
     */
    public function isValid(): bool
    {
        return $this->is_active
            && $this->start_date->isPast()
            && $this->end_date->isFuture();
    }

    /**
     * Calculate discount amount for a given product price.
     */
    public function calculateDiscount(float $price): float
    {
        $discount = 0;

        if ($this->discount_type === 'percentage') {
            $discount = $price * ($this->discount_value / 100);
        } elseif ($this->discount_type === 'fixed') {
            $discount = $this->discount_value;
        }

        return round($discount, 2);
    }
}
