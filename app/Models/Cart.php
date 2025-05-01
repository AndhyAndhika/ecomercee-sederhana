<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cart extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'user_id',
        'product_id',
        'qty',
        'is_checkout',
    ];

    /* relational to table user */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /* relational to table product */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

}
