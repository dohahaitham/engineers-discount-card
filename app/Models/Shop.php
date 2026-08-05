<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    // السماح بحفظ هذه الحقول في قاعدة البيانات
    protected $fillable = ['name', 'discount', 'address', 'details'];
}