<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'transaction';
    protected $primaryKey = 'transaction_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'url',
        'amount',
        'qris_id',
        'total_click',
    ];

    protected $casts = [
        'amount' => 'integer',
        'total_click' => 'integer',
    ];

    /**
     * Increment the total click count.
     */
    public function incrementClick(): void
    {
        $this->increment('total_click');
    }

    /**
     * Get the QRIS that owns the transaction.
     */
    public function qris(): BelongsTo
    {
        return $this->belongsTo(Qris::class, 'qris_id', 'qris_id');
    }
}
