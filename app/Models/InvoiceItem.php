<?php

namespace App\Models;

use Database\Factories\InvoiceItemFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    /** @use HasFactory<InvoiceItemFactory> */
    use HasFactory;

    protected $fillable = [
        'invoice_id',
        'product_id',
        'product_code',
        'product_name',
        'quantity',
        'unit_net_price',
        'vat_rate',
        'net_value',
        'vat_value',
        'gross_value',
    ];

    /**
     * Pozycja należy do faktury (Opcjonalnie dla wygody).
     */
    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    /**
     * Pozycja na fakturze należy do produktu.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
