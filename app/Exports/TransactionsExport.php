<?php

namespace App\Exports;

use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Http\Request;
use Carbon\Carbon;

class TransactionsExport implements FromQuery, WithHeadings, WithMapping
{
    use Exportable;

    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function query()
    {
        $startDate = $this->request->get('start_date', Carbon::now()->subDays(30)->format('Y-m-d'));
        $endDate = $this->request->get('end_date', Carbon::now()->format('Y-m-d'));
        
        $query = Transaction::query()->with(['user', 'details.product']);
        
        // Filter berdasarkan tanggal
        $query->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);
        
        // Filter berdasarkan status
        if ($this->request->has('status') && !empty($this->request->status)) {
            $query->where('status', $this->request->status);
        }
        
        return $query->orderBy('created_at', 'desc');
    }

    public function headings(): array
    {
        return [
            'Invoice Number',
            'Tanggal',
            'Pelanggan',
            'Total',
            'Metode Pembayaran',
            'Status',
            'Produk',
        ];
    }

    public function map($transaction): array
    {
        $products = [];
        foreach ($transaction->details as $detail) {
            $products[] = $detail->product->name . ' (' . $detail->quantity . 'x)';
        }
        
        return [
            $transaction->invoice_number,
            $transaction->created_at->format('d/m/Y H:i'),
            $transaction->customer_name ?? $transaction->user->name,
            number_format($transaction->total_amount, 0, ',', '.'),
            $transaction->payment_method,
            $transaction->status,
            implode(', ', $products),
        ];
    }
}
