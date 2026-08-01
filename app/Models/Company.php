<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'name',
        'tax_number',
        'email',
        'phone',
        'street',
        'city',
        'postal_code',
        'country',
    ];

    
}
