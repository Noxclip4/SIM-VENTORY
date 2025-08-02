<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice {{ $transaction->invoice_number }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            line-height: 1.5;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            margin-bottom: 5px;
        }
        .company-info {
            text-align: center;
            margin-bottom: 30px;
        }
        .invoice-details {
            width: 100%;
            margin-bottom: 20px;
        }
        .invoice-details td {
            padding: 5px;
        }
        table.items {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table.items th, table.items td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        table.items th {
            background-color: #f2f2f2;
        }
        .total-section {
            width: 100%;
            text-align: right;
        }
        .total-row {
            font-weight: bold;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>INVOICE</h1>
        <p>{{ $transaction->invoice_number }}</p>
    </div>
    
    <div class="company-info">
        <h2>SIM-VENTORY</h2>
        <p>Sistem Manajemen Inventaris dan Penjualan</p>
        <p>Jl. Contoh No. 123, Kota, Indonesia</p>
        <p>Telp: (021) 1234567 | Email: info@sim-ventory.com</p>
    </div>
    
    <table class="invoice-details">
        <tr>
            <td><strong>Tanggal:</strong></td>
            <td>{{ $transaction->created_at->format('d/m/Y H:i') }}</td>
            <td><strong>Status:</strong></td>
            <td>{{ ucfirst($transaction->status) }}</td>
        </tr>
        <tr>
            <td><strong>Pelanggan:</strong></td>
            <td>{{ $transaction->customer_name ?? $transaction->user->name }}</td>
            <td><strong>Pembayaran:</strong></td>
            <td>{{ $transaction->payment_method }}</td>
        </tr>
        @if($transaction->customer_phone || $transaction->customer_email)
        <tr>
            <td><strong>Telepon:</strong></td>
            <td>{{ $transaction->customer_phone ?? '-' }}</td>
            <td><strong>Email:</strong></td>
            <td>{{ $transaction->customer_email ?? '-' }}</td>
        </tr>
        @endif
        @if($transaction->notes)
        <tr>
            <td><strong>Catatan:</strong></td>
            <td colspan="3">{{ $transaction->notes }}</td>
        </tr>
        @endif
    </table>
    
    <h3>Detail Produk</h3>
    <table class="items">
        <thead>
            <tr>
                <th>No</th>
                <th>Produk</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaction->details as $index => $detail)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $detail->product->name }}</td>
                <td>Rp {{ number_format($detail->price_at_transaction, 0, ',', '.') }}</td>
                <td>{{ $detail->quantity }}</td>
                <td>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="total-section">
        <table style="width: 40%; float: right;">
            <tr>
                <td>Total:</td>
                <td>Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</td>
            </tr>
        </table>
    </div>
    
    <div style="clear: both;"></div>
    
    <div class="footer">
        <p>Terima kasih telah berbelanja di SIM-VENTORY</p>
        <p>{{ date('Y') }} © SIM-VENTORY. All rights reserved.</p>
    </div>
</body>
</html>
