<?php

namespace App\Models;

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string|null $tax_number
 * @property string|null $email
 * @property string|null $phone
 * @property string|null $street
 * @property string|null $city
 * @property string|null $postal_code
 * @property string|null $country
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 *
 * @mixin \Eloquent
 */
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
