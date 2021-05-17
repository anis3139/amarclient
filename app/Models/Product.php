<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['shop_id','name','sku'];

    public function sale(){
        return $this->belongsTo(Sale::class, 'product_id', 'id');
    }
}
