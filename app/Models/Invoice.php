<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'user_id',
        'price',
    ];

    public function product(): HasOne
    {
        return $this->hasOne(Products::class);
    }
    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }
}
