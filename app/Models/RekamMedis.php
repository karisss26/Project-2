<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RekamMedis extends Model
{
    // Kasih tau Laravel nama tabelnya (sesuaiin sama migration kamu ya)
    protected $table = 'rekam_medis';

    // Biar semua kolom bisa diisi (mass assignment)
    protected $guarded = [];

    // Relasi ke model hewan (biar $rm->hewan->nama_hewan nggak error)
    public function hewan()
    {
        return $this->belongsTo(hewan::class, 'hewan_id');
    }

    // Relasi ke user/dokter yang menangani
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
