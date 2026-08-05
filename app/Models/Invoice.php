<?php

namespace App\Models;

use Database\Factories\InvoiceFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    /** @use HasFactory<InvoiceFactory> */
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'invoice_number',
        'client_id',
        'issue_date',
        'sale_date',
        'due_date',
        'payment_method',
        'status',
        'total_net',
        'total_vat',
        'total_gross',
        'notes',
    ];

    protected $casts = [
        'issue_date' => 'datetime',
        'sale_date' => 'datetime',
        'due_date' => 'datetime',
        // 'due_date' => 'date'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
