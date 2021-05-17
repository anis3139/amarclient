<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $fillable = ['shop_id', 'transaction_type', 'transaction_id', 'given', 'taken', 'date', 'description'];
    protected $appends = ['user_type'];

    public function transactionable(){
        return $this->morphTo(__FUNCTION__, 'transaction_type', 'transaction_id');
    }

    public function getUserTypeAttribute(){
        return $this->transaction_type == Customer::class ? 'customer' : 'supplier';
    }
}
