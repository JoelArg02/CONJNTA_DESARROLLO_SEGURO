<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    protected $fillable = [
        'invoice_id',
        'product_id',
        'description',
        'quantity',
        'unit_price',
        'subtotal',   // se guarda ya calculado
    ];

    // ---------- RELACIONES ----------
    public function invoice()   { return $this->belongsTo(Invoice::class); }
    public function product()   { return $this->belongsTo(Product::class); }

    // ---------- EVENTOS ----------
    protected static function booted()
    {
        static::saving(function ($item) {
            // calcula subtotal antes de guardar
            $item->subtotal = $item->quantity * $item->unit_price;
        });
    }
}
