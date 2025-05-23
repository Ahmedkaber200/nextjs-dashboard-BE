<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Invoice extends Model
{
    protected $fillable = [
        'customer_id', 'total_amount', 'date', 'status', 'product_details'
    ];

     protected $casts = [
        'product_details' => 'array', // array of strings
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
}