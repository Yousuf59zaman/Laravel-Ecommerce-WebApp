<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * The `Order` model represents an order in the application.
 * It is associated with the `users` table through a `user_id` foreign key.
 * It also has a one-to-many relationship with the `order_details` table.
 */
class Order extends Model
{
    use HasFactory;

    
    /**
     * Specify the primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'order_id';
    

    /**
     * The attributes that are mass assignable.
     * These attributes can be set using the `create()` method or mass assignment.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'total', 'status'];

    /**
     * Define a relationship with the `User` model.
     * An order belongs to a user (many orders belong to one user).
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Define a relationship with the `OrderDetail` model.
     * An order has many order details (one order has multiple order items).
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'order_id');
    }
    
}

