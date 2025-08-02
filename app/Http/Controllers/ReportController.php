<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TransactionsExport;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        // Get date filters
        $startDate = $request->get('start_date', Carbon::now()->subDays(30)->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->format('Y-m-d'));
        $categoryFilter = $request->get('category');

        // Base query for transactions
        $transactionsQuery = Transaction::whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);

        // Apply category filter if selected
        if ($categoryFilter) {
            $transactionsQuery->whereHas('details.product', function($query) use ($categoryFilter) {
                $query->where('category_id', $categoryFilter);
            });
        }

        // Get all categories for filter dropdown
        $categories = Category::all();

        // Calculate statistics
        $totalTransactions = $transactionsQuery->count();
        $totalRevenue = $transactionsQuery->where('status', 'completed')->sum('total_amount');
        $averageTransaction = $totalTransactions > 0 ? $totalRevenue / $totalTransactions : 0;
        
        // Calculate total products sold
        $totalProductsSold = DB::table('transaction_details')
            ->join('transactions', 'transaction_details.transaction_id', '=', 'transactions.id')
            ->whereBetween('transactions.created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->where('transactions.status', 'completed')
            ->sum('transaction_details.quantity');

        // Get top categories with revenue using raw query
        $topCategories = DB::table('categories')
            ->select(
                'categories.id',
                'categories.name',
                DB::raw('COUNT(DISTINCT products.id) as total_products'),
                DB::raw('COALESCE(SUM(transaction_details.quantity), 0) as total_sold'),
                DB::raw('COALESCE(SUM(transaction_details.subtotal), 0) as total_revenue')
            )
            ->leftJoin('products', 'categories.id', '=', 'products.category_id')
            ->leftJoin('transaction_details', 'products.id', '=', 'transaction_details.product_id')
            ->leftJoin('transactions', 'transaction_details.transaction_id', '=', 'transactions.id')
            ->where(function($query) use ($startDate, $endDate) {
                $query->whereNull('transactions.created_at')
                      ->orWhere(function($q) use ($startDate, $endDate) {
                          $q->whereBetween('transactions.created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
                            ->where('transactions.status', 'completed');
                      });
            })
            ->groupBy('categories.id', 'categories.name')
            ->orderBy('total_sold', 'desc')
            ->limit(5)
            ->get();

        // Get top products with revenue using raw query
        $topProducts = DB::table('products')
            ->select(
                'products.id',
                'products.name',
                'products.image',
                'categories.name as category_name',
                DB::raw('COALESCE(SUM(transaction_details.quantity), 0) as total_sold'),
                DB::raw('COALESCE(SUM(transaction_details.subtotal), 0) as total_revenue')
            )
            ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
            ->leftJoin('transaction_details', 'products.id', '=', 'transaction_details.product_id')
            ->leftJoin('transactions', 'transaction_details.transaction_id', '=', 'transactions.id')
            ->where(function($query) use ($startDate, $endDate) {
                $query->whereNull('transactions.created_at')
                      ->orWhere(function($q) use ($startDate, $endDate) {
                          $q->whereBetween('transactions.created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
                            ->where('transactions.status', 'completed');
                      });
            })
            ->groupBy('products.id', 'products.name', 'products.image', 'categories.name')
            ->orderBy('total_sold', 'desc')
            ->limit(10)
            ->get();

        // Get recent transactions
        $recentTransactions = Transaction::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Get daily sales data for chart
        $salesData = $this->getDailySalesData($startDate, $endDate);

        // Get category distribution data for chart
        $categoryData = $this->getCategoryDistributionData($startDate, $endDate);

        return view('reports.index', compact(
            'startDate',
            'endDate',
            'categories',
            'totalTransactions',
            'totalRevenue',
            'averageTransaction',
            'totalProductsSold',
            'topCategories',
            'topProducts',
            'recentTransactions',
            'salesData',
            'categoryData'
        ));
    }

    public function exportPDF(Request $request)
    {
        $startDate = $request->get('start_date', Carbon::now()->subDays(30)->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->format('Y-m-d'));

        $transactions = Transaction::whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);
        $totalSales = $transactions->where('status', 'completed')->sum('total_amount');
        $totalTransactions = $transactions->count();
        $completedTransactions = $transactions->where('status', 'completed')->count();

        $recentTransactions = Transaction::with('user')
            ->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->orderBy('created_at', 'desc')
            ->get();

        $pdf = Pdf::loadView('reports.pdf', compact(
            'startDate',
            'endDate',
            'totalSales',
            'totalTransactions',
            'completedTransactions',
            'recentTransactions'
        ));

        return $pdf->download('laporan-transaksi-' . $startDate . '-to-' . $endDate . '.pdf');
    }

    public function exportExcel(Request $request)
    {
        $startDate = $request->get('start_date', Carbon::now()->subDays(30)->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->format('Y-m-d'));

        return Excel::download(new TransactionsExport($request), 'laporan-transaksi-' . $startDate . '-to-' . $endDate . '.xlsx');
    }

    private function getDailySalesData($startDate, $endDate)
    {
        $labels = [];
        $values = [];

        $start = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);

        for ($date = $start; $date->lte($end); $date->addDay()) {
            $labels[] = $date->format('d/m');
            
            $dailySales = Transaction::where('status', 'completed')
                ->whereDate('created_at', $date)
                ->sum('total_amount');
            
            $values[] = $dailySales;
        }

        return [
            'labels' => $labels,
            'values' => $values
        ];
    }

    private function getCategoryDistributionData($startDate, $endDate)
    {
        $categories = DB::table('categories')
            ->select(
                'categories.name',
                DB::raw('COALESCE(SUM(transaction_details.quantity), 0) as total_sold')
            )
            ->leftJoin('products', 'categories.id', '=', 'products.category_id')
            ->leftJoin('transaction_details', 'products.id', '=', 'transaction_details.product_id')
            ->leftJoin('transactions', 'transaction_details.transaction_id', '=', 'transactions.id')
            ->where(function($query) use ($startDate, $endDate) {
                $query->whereNull('transactions.created_at')
                      ->orWhere(function($q) use ($startDate, $endDate) {
                          $q->whereBetween('transactions.created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
                            ->where('transactions.status', 'completed');
                      });
            })
            ->groupBy('categories.name')
            ->get();
        
        $labels = $categories->pluck('name')->toArray();
        $values = $categories->pluck('total_sold')->toArray();

        return [
            'labels' => $labels,
            'values' => $values
        ];
    }
}
