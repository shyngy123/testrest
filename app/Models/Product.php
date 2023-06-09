<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [ 
          'name',
          'discription',
          'slug',
     ];
    
    public function category()
    {
    
    return $this->belongsTo(Category::class);
    
    }

    public function carts()
    {
    
    return $this->hasMany(Cart::class);
    
    }

    public function orderItems()
    {
    
    return $this->hasMany(OrderItem::class);
    
    }
}
