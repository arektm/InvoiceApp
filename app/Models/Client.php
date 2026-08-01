<?php

namespace App\Models;

use Database\Factories\ClientFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    /** @use HasFactory<ClientFactory> */
    use HasFactory;

    use SoftDeletes;

    protected $fillable = [
        'name',
        'first_name',
        'last_name',
        'tax_number',
        'email',
        'phone',
        'street',
        'city',
        'postal_code',
        'country',
    ];

    // public function invoices()
    // {
    //     return $this->hasMany(Invoice::class);
    // }
}
