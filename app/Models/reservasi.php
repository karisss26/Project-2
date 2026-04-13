<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class reservasi extends Model
{
    // Kasih tahu Laravel kalau nama tabelnya adalah 'reservasi'
    protected $table = 'reservasi';

    protected $guarded = [];
}
