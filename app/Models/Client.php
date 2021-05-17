<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    protected $fillable = ['shop_id', 'name', 'company', 'phone_number_1', 'phone_number_2', 'email', 'notes', 'address', 'website', 'country_id', 'division_id', 'district_id', 'upazila_id'];

    public function country(){
        return $this->belongsTo(Country::class);
    }
    public function division(){
        return $this->belongsTo(Division::class);
    }
    public function district(){
        return $this->belongsTo(District::class);
    }
    public function upazila(){
        return $this->belongsTo(Upazila::class);
    }
    
    public function sale(){
        return $this->belongsTo(Sale::class, 'client_id', 'id');
    }
    
}
