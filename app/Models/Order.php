<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public $timestamps = true;
    protected $table = "order";
    protected $fillable = [
        'customer_id',
        'total_harga',
        'status',
        'noresi',
        'kurir',
        'layanan_ongkir',
        'biaya_ongkir',
        'estimasi_ongkir',
        'total_berat',
        'alamat',
        'pos',
        'voucher_code',
        'voucher_discount',
    ];
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'id');
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }
    public function returs()
    {
        return $this->hasMany(Retur::class, 'order_id', 'id');
    }
}
