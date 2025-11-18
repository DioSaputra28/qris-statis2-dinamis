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
     * Get masked key for display.
     * Since key is hashed, we show a generic masked format.
     */
    public function getMaskedKeyAttribute(): string
    {
        // Show first 8 chars of hash for identification
        $prefix = substr($this->key, 0, 8);
        return $prefix . '••••••••••••••••••••••••';
    }
}
