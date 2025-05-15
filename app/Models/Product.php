<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name', 'description', 'price'
    ];

    public function invoice(): hasMany
    {
        return $this->hasMany(Invoice::class);
    }

    // public function product(): BelongsTo
    // {
    //     return $this->belongsTo(Product::class);
    // }
}
