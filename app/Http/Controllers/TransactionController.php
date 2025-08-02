<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TransactionsExport;

class TransactionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:staff')->only(['create', 'store', 'edit', 'update', 'destroy']);
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Transaction::with(['user', 'details.product']);
        
        // Pencarian berdasarkan nomor invoice
        if ($request->has('search')) {
            $search = $request->search;
            $query->where('invoice_number', 'like', "%{$search}%");
        }
        
        // Filter berdasarkan status
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }
        
        // Filter berdasarkan tanggal
        if ($request->has('date_from') && !empty($request->date_from)) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        
        if ($request->has('date_to') && !empty($request->date_to)) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        
        // Sorting
        $sort = $request->sort ?? 'created_at';
        $direction = $request->direction ?? 'desc';
        $query->orderBy($sort, $direction);
        
        $transactions = $query->paginate(10);
        
        return view('transactions.index', compact('transactions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::where('stock_quantity', '>', 0)->get();
        return view('transactions.create', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'nullable|string|max:20',
            'customer_email' => 'nullable|email|max:255',
            'product_id' => 'required|array',
            'product_id.*' => 'exists:products,id',
            'quantity' => 'required|array',
            'quantity.*' => 'integer|min:1',
            'payment_method' => 'required|string',
            'notes' => 'nullable|string',
        ]);
        
        $total_amount = 0;
        
        // Hitung total amount dan validasi stok
        foreach ($request->product_id as $key => $id) {
            $product = Product::findOrFail($id);
            $quantity = $request->quantity[$key];
            
            if ($product->stock_quantity < $quantity) {
                return back()->with('error', "Stok {$product->name} tidak mencukupi.");
            }
            
            $total_amount += $product->price * $quantity;
        }
        
        // Buat transaksi baru
        $transaction = Transaction::create([
            'invoice_number' => 'INV-' . date('Ymd') . '-' . Str::upper(Str::random(5)),
            'user_id' => Auth::id(),
            'customer_name' => $request->customer_name,
            'customer_phone' => $request->customer_phone,
            'customer_email' => $request->customer_email,
            'total_amount' => $total_amount,
            'payment_method' => $request->payment_method,
            'status' => 'pending', // Default pending, perlu konfirmasi pembayaran
            'notes' => $request->notes,
        ]);
        
        // Buat detail transaksi dan kurangi stok
        foreach ($request->product_id as $key => $id) {
            $product = Product::findOrFail($id);
            $quantity = $request->quantity[$key];
            
            TransactionDetail::create([
                'transaction_id' => $transaction->id,
                'product_id' => $id,
                'quantity' => $quantity,
                'price_at_transaction' => $product->price,
                'subtotal' => $product->price * $quantity,
            ]);
            
            // Kurangi stok
            $product->update([
                'stock_quantity' => $product->stock_quantity - $quantity
            ]);
        }
        
        return redirect()->route('transactions.show', $transaction)
            ->with('success', 'Transaksi berhasil dibuat!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        $transaction->load(['user', 'details.product']);
        return view('transactions.show', compact('transaction'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        $transaction->load(['user', 'details.product']);
        return view('transactions.edit', compact('transaction'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        $request->validate([
            'status' => 'required|in:pending,completed,cancelled',
            'notes' => 'nullable|string',
        ]);
        
        $transaction->update([
            'status' => $request->status,
            'notes' => $request->notes,
        ]);
        
        return redirect()->route('transactions.show', $transaction)
            ->with('success', 'Status transaksi berhasil diperbarui!');
    }

    /**
     * Export transaction to PDF.
     */
    public function exportPDF(Transaction $transaction)
    {
        $transaction->load(['user', 'details.product']);
        
        $pdf = PDF::loadView('transactions.pdf', compact('transaction'));
        
        return $pdf->download('invoice-' . $transaction->invoice_number . '.pdf');
    }

    /**
     * Export transactions to Excel.
     */
    public function exportExcel(Request $request)
    {
        return Excel::download(new TransactionsExport($request), 'transactions-' . date('Y-m-d') . '.xlsx');
    }
}
