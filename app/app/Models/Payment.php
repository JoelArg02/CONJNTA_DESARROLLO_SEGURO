<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'invoice_id',
        'amount',
        'method',
        'status',
        'transaction_reference',
        'paid_at',
        'validated_at',
        'created_by',
        'soft_delete_reason',
        'soft_deleted_by',
        'notes',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
        'validated_at' => 'datetime',
        'amount'  => 'decimal:2',
    ];

    public function invoice(): BelongsTo     { return $this->belongsTo(Invoice::class); }
    public function creator(): BelongsTo     { return $this->belongsTo(User::class, 'created_by'); }
    public function softDeleter(): BelongsTo { return $this->belongsTo(User::class, 'soft_deleted_by'); }
}
