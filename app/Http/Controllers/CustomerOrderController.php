<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CustomerOrderController extends Controller
{
    public function index(): View
    {
        return view('customer.orders.index', [
            'metaTitle' => 'Order History | M&M Custom Tackle',
            'orders' => Auth::user()->orders()->latest()->paginate(10),
        ]);
    }

    public function show(Order $order): View
    {
        abort_unless($order->user_id === Auth::id(), 403);

        return view('customer.orders.show', [
            'metaTitle' => 'Order '.$order->order_number.' | M&M Custom Tackle',
            'order' => $order->load(['items.product', 'payment']),
        ]);
    }
}
