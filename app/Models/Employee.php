<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $fillable = ['shop_id','name','email','mobile','dob','employee_type','salary_type','amount','salary_circle','job_id','job_title','holiday','from','to'];
}
