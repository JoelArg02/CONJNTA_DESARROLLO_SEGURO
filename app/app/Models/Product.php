<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'stock', 'price', 'sale_price', 'is_active', 'deactivation_reason'];

    public function invoiceItems()
    {
        return $this->hasMany(InvoiceItem::class);
    }
}
