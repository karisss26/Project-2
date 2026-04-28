<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;

/**
 * @property-read User $user
 */
class reservasi extends Model
{
    // Kasih tahu Laravel kalau nama tabelnya adalah 'reservasi'
    protected $table = 'reservasi';

    protected $guarded = [];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
