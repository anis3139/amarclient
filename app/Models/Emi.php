<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Emi extends Model
{
    use HasFactory;
    protected $fillable = ['shop_id','product_id','customer_id','total_amount','total_installment','down_payment','start_date','end_date'];

    public function shop(){
        return $this->belongsTo(Shop::class);
    }
    public function product(){
        return $this->belongsTo(Product::class);
    }
    public function customer(){
        return $this->belongsTo(Customer::class);
    }
}
