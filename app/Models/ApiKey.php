<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ApiKey extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'apikeys';
    protected $primaryKey = 'apikey_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'user_id',
        'name',
        'key',
        'total_call',
    ];

    protected $casts = [
        'total_call' => 'integer',
    ];

    protected $hidden = [
        'key',
    ];

    /**
     * Get the user that owns the API key.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    /**
     * Increment the total call count.
     */
    public function incrementCall(): void
    {
        $this->increment('total_call');
    }

    /**
     * Get masked key for display (e.g., sk_live_abc123...xyz789).
     */
    public function getMaskedKeyAttribute(): string
    {
        if (strlen($this->key) <= 20) {
            return $this->key;
        }

        $start = substr($this->key, 0, 15);
        $end = substr($this->key, -6);

        return $start . '...' . $end;
    }
}
