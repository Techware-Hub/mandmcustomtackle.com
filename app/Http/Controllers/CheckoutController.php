<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function index(): View|RedirectResponse
    {
        $cartItems = $this->cartItems();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('success', 'Add a product to your cart before checkout.');
        }

        $subtotal = $cartItems->sum('lineTotal');

        return view('checkout.index', [
            'metaTitle' => 'Checkout | M&M Custom Tackle',
            'metaDescription' => 'Complete your M&M Custom Tackle order.',
            'cartItems' => $cartItems,
            'subtotal' => $subtotal,
            'shipping' => $subtotal > 0 ? 8.00 : 0,
            'tax' => 0,
        ]);
    }

    public function placeOrder(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:50'],
            'address' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:100'],
            'state' => ['required', 'string', 'max:100'],
            'zip' => ['required', 'string', 'max:20'],
            'notes' => ['nullable', 'string', 'max:2000'],
            'payment_method' => ['required', 'in:cash_on_delivery,manual_payment,card_placeholder'],
        ]);

        if (empty(session('cart', []))) {
            return redirect()->route('cart.index')->with('success', 'Your cart is empty.');
        }

        $order = DB::transaction(function () use ($validated) {
            $cart = collect(session('cart', []))
                ->mapWithKeys(fn ($quantity, $productId) => [(int) $productId => (int) $quantity])
                ->filter(fn ($quantity) => $quantity > 0);

            /** @var EloquentCollection<int, Product> $products */
            $products = Product::query()
                ->whereIn('id', $cart->keys())
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            abort_if($products->isEmpty(), 422, 'Your cart does not contain valid products.');

            $items = $cart->map(function (int $quantity, int $productId) use ($products) {
                $product = $products->get($productId);

                abort_if(! $product || ! $product->isPurchasable(), 422, 'One or more products in your cart are no longer available.');
                abort_if($quantity > $product->stock, 422, $product->name.' does not have enough stock available.');

                $price = $product->currentPrice();

                return [
                    'product' => $product,
                    'quantity' => $quantity,
                    'price' => $price,
                    'total' => $price * $quantity,
                ];
            });

            $subtotal = (float) $items->sum('total');
            $shipping = $subtotal > 0 ? 8.00 : 0.00;
            $tax = 0.00;
            $total = $subtotal + $shipping + $tax;

            $order = Order::create([
                'user_id' => auth()->id(),
                'order_number' => $this->makeOrderNumber(),
                'customer_name' => $validated['name'],
                'customer_email' => $validated['email'],
                'customer_phone' => $validated['phone'],
                'shipping_address' => $validated['address'],
                'city' => $validated['city'],
                'state' => $validated['state'],
                'zip_code' => $validated['zip'],
                'order_notes' => $validated['notes'] ?? null,
                'subtotal' => $subtotal,
                'shipping_amount' => $shipping,
                'tax_amount' => $tax,
                'total_amount' => $total,
                'payment_method' => $validated['payment_method'],
                'payment_status' => 'pending',
                'order_status' => 'pending',
            ]);

            $items->each(function (array $item) use ($order) {
                /** @var Product $product */
                $product = $item['product'];

                $order->items()->create([
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'product_price' => $item['price'],
                    'quantity' => $item['quantity'],
                    'total' => $item['total'],
                ]);

                $product->decrement('stock', $item['quantity']);
            });

            $order->payment()->create([
                'payment_method' => $validated['payment_method'],
                'transaction_id' => null,
                'amount' => $total,
                'status' => 'pending',
                // TODO: Store Stripe or PayPal response payload here after gateway integration.
                'payment_response' => null,
            ]);

            return $order;
        });

        session()->forget('cart');

        return redirect()->route('checkout.success', $order)->with('success', 'Your order was placed successfully.');
    }

    public function success(Order $order): View
    {
        $order->load(['items', 'payment']);

        return view('checkout.success', [
            'metaTitle' => 'Order '.$order->order_number.' | M&M Custom Tackle',
            'metaDescription' => 'Thank you for your M&M Custom Tackle order.',
            'order' => $order,
        ]);
    }

    private function cartItems()
    {
        $cart = collect(session('cart', []))
            ->mapWithKeys(fn ($quantity, $productId) => [(int) $productId => (int) $quantity])
            ->filter(fn ($quantity) => $quantity > 0);

        if ($cart->isEmpty()) {
            return collect();
        }

        $products = Product::query()
            ->with('category')
            ->whereIn('id', $cart->keys())
            ->where('status', 'active')
            ->get()
            ->keyBy('id');

        return $cart->map(function ($quantity, $productId) use ($products) {
            $product = $products->get($productId);
            if (! $product || $product->stock <= 0) {
                return null;
            }

            $quantity = min((int) $quantity, $product->stock);

            return (object) [
                'product' => $product,
                'quantity' => $quantity,
                'lineTotal' => $product->currentPrice() * $quantity,
            ];
        })->filter()->values();
    }

    private function makeOrderNumber(): string
    {
        do {
            $number = 'MM-'.now()->format('Ymd').'-'.str_pad((string) random_int(1, 99999), 5, '0', STR_PAD_LEFT);
        } while (Order::where('order_number', $number)->exists());

        return $number;
    }
}
