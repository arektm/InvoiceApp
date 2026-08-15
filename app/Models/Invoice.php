<?php

namespace App\Models;

use Carbon\Carbon;
use Database\Factories\InvoiceFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property string $invoice_number
 * @property int $client_id
 * @property Carbon $issue_date
 * @property Carbon $sale_date
 * @property Carbon $due_date
 * @property string $payment_method
 * @property string $status
 * @property numeric $total_net
 * @property numeric $total_vat
 * @property numeric $total_gross
 * @property string $reference
 * @property string $note
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon $deleted_at
 * @property-read Client $client
 * @property-read Company $company
 * @property-read Collection<int, InvoiceItem> $items
 * @property-read int $items_count
 * @property bool $overdue
 * @property Carbon|null $deleted_at
 *
 * @mixin \Eloquent
 */
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

    /**
     * @return BelongsTo<Client, $this>
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * @return HasMany<InvoiceItem, $this>
     */
    public function items(): HasMany
    {
        return $this->hasMany(InvoiceItem::class);
    }

    /**
     * @return BelongsTo<Company, $this>
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
