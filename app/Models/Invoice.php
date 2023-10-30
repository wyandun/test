<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    
    public function product(): HasOne
    {
        return $this->hasOne(Products::class);
    }
    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }
}
