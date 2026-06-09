<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
    use HasFactory;

    protected $fillable = [
        'type', 'judul', 'pesan', 'url', 'is_read',
    ];

    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    public static function buat($type, $judul, $pesan, $url = null)
    {
        return static::create([
            'type' => $type,
            'judul' => $judul,
            'pesan' => $pesan,
            'url' => $url,
            'is_read' => false,
        ]);
    }
}
