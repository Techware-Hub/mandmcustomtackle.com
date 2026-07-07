<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminOrderController extends Controller
{
    public function index(Request $request): View
    {
        $orders = Order::query()
            ->when($request->status, fn ($query, $status) => $query->where('order_status', $status))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order): View
    {
        $order->load(['items.product', 'payment', 'user']);

        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order): RedirectResponse
    {
        $validated = $request->validate([
            'order_status' => ['required', 'in:pending,processing,completed,cancelled'],
            'payment_status' => ['required', 'in:pending,paid,failed,refunded'],
        ]);

        $order->update($validated);
        $order->payment?->update(['status' => $validated['payment_status']]);

        return back()->with('success', 'Order status updated.');
    }
}
