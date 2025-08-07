<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'customer_id',
        'invoice_number',
        'subtotal',
        'tax_amount',
        'total',
        'status',
        'notes',
        'issued_at',
        'created_by',
        'soft_delete_reason',
        'soft_deleted_by',
    ];

    protected $casts = [
        'issued_at' => 'datetime',
        'total' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'tax_amount' => 'decimal:2',
    ];

    // ---------- RELACIONES ----------
    public function customer(): BelongsTo { return $this->belongsTo(Customer::class); }
    public function items():    HasMany   { return $this->hasMany(InvoiceItem::class); }
    public function creator():  BelongsTo { return $this->belongsTo(User::class, 'created_by'); }
    public function softDeleter(): BelongsTo { return $this->belongsTo(User::class, 'soft_deleted_by'); }

    // ---------- UTIL ----------
    public function refreshTotal(): void
    {
        $subtotal = $this->items()->sum('subtotal');
        $taxRate = 0.18; // 18% IGV
        $taxAmount = $subtotal * $taxRate;
        $total = $subtotal + $taxAmount;

        $this->updateQuietly([
            'subtotal' => $subtotal,
            'tax_amount' => $taxAmount,
            'total' => $total
        ]);
    }

    public static function generateInvoiceNumber(): string
    {
        $year = date('Y');
        $lastInvoice = self::whereYear('created_at', $year)
            ->where('invoice_number', 'like', "FAC-{$year}-%")
            ->orderBy('invoice_number', 'desc')
            ->first();

        if ($lastInvoice) {
            preg_match('/FAC-\d{4}-(\d+)/', $lastInvoice->invoice_number, $matches);
            $nextNumber = isset($matches[1]) ? intval($matches[1]) + 1 : 1;
        } else {
            $nextNumber = 1;
        }

        return "FAC-{$year}-" . str_pad($nextNumber, 6, '0', STR_PAD_LEFT);
    }
}
