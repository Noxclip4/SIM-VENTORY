<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'invoice_number',
        'user_id',
        'total_amount',
        'payment_method',
        'status',
        'notes',
        'customer_name',
        'customer_phone',
        'customer_email',
        'tax_amount',
        'discount_amount',
        'subtotal',
        'payment_status',
        'due_date'
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'due_date' => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function details()
    {
        return $this->hasMany(TransactionDetail::class);
    }

    // Accessor untuk total setelah diskon dan pajak
    public function getFinalTotalAttribute()
    {
        return $this->subtotal + $this->tax_amount - $this->discount_amount;
    }

    // Accessor untuk status pembayaran
    public function getPaymentStatusTextAttribute()
    {
        switch ($this->payment_status) {
            case 'paid':
                return 'Lunas';
            case 'partial':
                return 'Bayar Sebagian';
            case 'unpaid':
                return 'Belum Bayar';
            default:
                return 'Unknown';
        }
    }

    // Scope untuk transaksi hari ini
    public function scopeToday($query)
    {
        return $query->whereDate('created_at', today());
    }

    // Scope untuk transaksi minggu ini
    public function scopeThisWeek($query)
    {
        return $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
    }

    // Scope untuk transaksi bulan ini
    public function scopeThisMonth($query)
    {
        return $query->whereMonth('created_at', now()->month);
    }

    // Scope untuk transaksi yang belum lunas
    public function scopeUnpaid($query)
    {
        return $query->where('payment_status', '!=', 'paid');
    }
}
