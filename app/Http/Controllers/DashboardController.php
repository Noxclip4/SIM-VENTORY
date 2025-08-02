<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // Statistics
        $totalProducts = Product::count();
        $totalTransactions = Transaction::count();
        $todayTransactions = Transaction::whereDate('created_at', today())->count();
        $totalRevenue = Transaction::where('status', 'completed')->sum('total_amount');

        // Low stock products (less than 10)
        $lowStockProducts = Product::where('stock_quantity', '<', 10)
            ->with('category')
            ->orderBy('stock_quantity', 'asc')
            ->limit(5)
            ->get();

        // Recent transactions
        $recentTransactions = Transaction::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Sales data for chart (last 7 days)
        $salesData = $this->getDailySalesData();

        // Category distribution data
        $categoryData = $this->getCategoryDistributionData();

        return view('dashboard', compact(
            'totalProducts',
            'totalTransactions',
            'todayTransactions',
            'totalRevenue',
            'lowStockProducts',
            'recentTransactions',
            'salesData',
            'categoryData'
        ));
    }

    private function getDailySalesData()
    {
        $labels = [];
        $values = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
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

    private function getCategoryDistributionData()
    {
        $categories = Category::withCount('products')->get();
        
        $labels = $categories->pluck('name')->toArray();
        $values = $categories->pluck('products_count')->toArray();

        return [
            'labels' => $labels,
            'values' => $values
        ];
    }
}
