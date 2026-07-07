<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Models\BlogPost;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('admin.dashboard', [
            'metaTitle' => 'Admin Dashboard | M&M Custom Tackle',
            'totalProducts' => Product::count(),
            'totalCategories' => Category::count(),
            'totalOrders' => Order::count(),
            'pendingOrders' => Order::where('order_status', 'pending')->count(),
            'completedOrders' => Order::where('order_status', 'completed')->count(),
            'totalRevenue' => Order::where('payment_status', 'paid')->sum('total_amount'),
            'totalCustomers' => User::where('role', 'customer')->count(),
            'totalContactMessages' => ContactMessage::count(),
            'lowStockProducts' => Product::with('category')->where('stock', '<=', 5)->orderBy('stock')->take(8)->get(),
            'totalBlogs' => BlogPost::count(),
            'recentOrders' => Order::with('items')->latest()->take(8)->get(),
            'recentContactMessages' => ContactMessage::latest()->take(6)->get(),
        ]);
    }
}
