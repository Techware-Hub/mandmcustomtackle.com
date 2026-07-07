<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TrackOrderController extends Controller
{
    public function index(): View
    {
        return view('customer.track-order', ['metaTitle' => 'Track Order | M&M Custom Tackle']);
    }

    public function search(Request $request): View
    {
        $validated = $request->validate([
            'order_number' => ['required', 'string'],
            'email' => ['required', 'email'],
        ]);

        $order = Order::with(['items', 'payment'])
            ->where('order_number', $validated['order_number'])
            ->where('customer_email', $validated['email'])
            ->first();

        return view('customer.track-order', [
            'metaTitle' => 'Track Order | M&M Custom Tackle',
            'order' => $order,
            'searched' => true,
        ]);
    }
}
