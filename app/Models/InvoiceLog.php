<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceLog extends Model
{
    use HasFactory;

    protected $fillable = ['shop_id', 'sale_id', 'payment_method', 'note', 'payment_amount', 'payment_date'];

    public function shop(){
        return $this->belongsTo(Shop::class);
    }
    public function sale(){
        return $this->belongsTo(Sale::class);
    }
}
