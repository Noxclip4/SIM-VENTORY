<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan SIM-VENTORY</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #1e40af;
            padding-bottom: 20px;
        }
        .header h1 {
            color: #1e40af;
            margin: 0;
            font-size: 24px;
        }
        .header p {
            color: #666;
            margin: 5px 0 0 0;
        }
        .info-section {
            margin-bottom: 20px;
        }
        .info-section h3 {
            color: #1e40af;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
        }
        .stats-grid {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .stat-box {
            background: #f8f9fa;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            text-align: center;
            flex: 1;
            margin: 0 5px;
        }
        .stat-box h4 {
            margin: 0 0 10px 0;
            color: #1e40af;
            font-size: 14px;
        }
        .stat-box .value {
            font-size: 20px;
            font-weight: bold;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f8f9fa;
            font-weight: bold;
            color: #1e40af;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            color: #666;
            font-size: 12px;
            border-top: 1px solid #ddd;
            padding-top: 20px;
        }
        .page-break {
            page-break-before: always;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>SIM-VENTORY</h1>
        <p>Sistem Manajemen Inventaris dan Penjualan</p>
        <p>Laporan Transaksi Periode: {{ $startDate }} - {{ $endDate }}</p>
    </div>

    <div class="info-section">
        <h3>Ringkasan Statistik</h3>
        <div class="stats-grid">
            <div class="stat-box">
                <h4>Total Penjualan</h4>
                <div class="value">Rp {{ number_format($totalSales) }}</div>
            </div>
            <div class="stat-box">
                <h4>Total Transaksi</h4>
                <div class="value">{{ number_format($totalTransactions) }}</div>
            </div>
            <div class="stat-box">
                <h4>Transaksi Selesai</h4>
                <div class="value">{{ number_format($completedTransactions) }}</div>
            </div>
        </div>
    </div>

    <div class="info-section">
        <h3>Detail Transaksi</h3>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Invoice</th>
                    <th>Customer</th>
                    <th>Tanggal</th>
                    <th>Total</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentTransactions as $index => $transaction)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $transaction->invoice_number }}</td>
                    <td>{{ $transaction->customer_name ?? $transaction->user->name }}</td>
                    <td>{{ $transaction->created_at->format('d/m/Y H:i') }}</td>
                    <td>Rp {{ number_format($transaction->total_amount) }}</td>
                    <td>
                        @if($transaction->status == 'completed')
                            <span style="color: #10b981; font-weight: bold;">Selesai</span>
                        @elseif($transaction->status == 'pending')
                            <span style="color: #f59e0b; font-weight: bold;">Pending</span>
                        @else
                            <span style="color: #ef4444; font-weight: bold;">Dibatalkan</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align: center; color: #666;">
                        Tidak ada transaksi dalam periode ini
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="footer">
        <p>Laporan ini dibuat secara otomatis oleh sistem SIM-VENTORY</p>
        <p>Dicetak pada: {{ now()->format('d F Y H:i:s') }}</p>
    </div>
</body>
</html> 