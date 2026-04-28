<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ReservasiNotification extends Notification
{
    use Queueable;

    // Tambahkan dua baris ini agar variabel bisa diakses di seluruh class
    public $reservasi;
    public $status;

    // Update bagian __construct untuk menangkap kiriman dari Controller
    public function __construct($reservasi, $status)
    {
        $this->reservasi = $reservasi;
        $this->status = $status;
    }

    public function via($notifiable)
    {
        return ['database']; // Menyimpan notifikasi ke tabel notifications
    }

    public function toArray($notifiable)
    {
        return [
            'id_reservasi' => $this->reservasi->id,
            'pesan' => 'Reservasi Anda pada tanggal ' . $this->reservasi->tanggal . ' telah ' . $this->status . '.',
            'status' => $this->status,
        ];
    }
}
