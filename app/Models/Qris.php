<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Qris extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'qris';
    protected $primaryKey = 'qris_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'name',
        'user_id',
        'img_url',
        'qr_code',
    ];

    /**
     * Get the user that owns the QRIS.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    /**
     * Get the transactions for the QRIS.
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'qris_id', 'qris_id');
    }
}
