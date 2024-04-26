<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description', 'price', 'image'];
// This is where you could add any model event hooks if needed
protected static function booted()
{
    static::deleting(function ($product) {
        // Remove image file or handle related data
    });
}

}
