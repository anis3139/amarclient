<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = ['shop_id','supplier_id', 'item_name', 'amount', 'date', 'description'];

    public function shop(){
        return $this->belongsTo(Shop::class);
    }
//    public function product(){
//        return $this->belongsTo(Product::class);
//    }
    public function supplier(){
        return $this->belongsTo(Supplier::class);
    }
}
