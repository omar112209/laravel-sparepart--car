<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;

    protected $table = 'vouchers';
    protected $fillable = [
        'kode',
        'tipe',
        'nilai',
        'min_belanja',
        'maks_diskon',
        'tanggal_mulai',
        'tanggal_berakhir',
        'batas_pakai',
        'dipakai',
        'status',
        'deskripsi',
    ];

    public function usage()
    {
        return $this->hasMany(VoucherUsage::class, 'voucher_id');
    }

    public function isValid($subtotal = 0)
    {
        $now = now()->format('Y-m-d');
        if ($this->status !== 'aktif') return false;
        if ($this->tanggal_mulai > $now || $this->tanggal_berakhir < $now) return false;
        if ($this->batas_pakai > 0 && $this->dipakai >= $this->batas_pakai) return false;
        if ($subtotal > 0 && $subtotal < $this->min_belanja) return false;
        return true;
    }

    public function calculateDiscount($subtotal)
    {
        if ($this->tipe === 'persen') {
            $diskon = $subtotal * $this->nilai / 100;
            if ($this->maks_diskon && $diskon > $this->maks_diskon) {
                $diskon = $this->maks_diskon;
            }
            return $diskon;
        }
        return min($this->nilai, $subtotal);
    }
}
