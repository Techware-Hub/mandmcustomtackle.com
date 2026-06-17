<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    public function index(): View
    {
        return $this->viewCart();
    }

    public function viewCart(): View
    {
        $cartItems = $this->cartItems();

        return view('cart.index', [
            'metaTitle' => 'Shopping Cart | M&M Custom Tackle',
            'metaDescription' => 'Review your custom fishing tackle order before checkout.',
            'cartItems' => $cartItems,
            'subtotal' => $cartItems->sum('lineTotal'),
            'shipping' => $cartItems->isNotEmpty() ? 8.00 : 0,
        ]);
    }

    public function addToCart(Request $request, Product $product): RedirectResponse
    {
        abort_unless($product->isPurchasable(), 404);

        $validated = $request->validate([
            'quantity' => ['nullable', 'integer', 'min:1', 'max:99'],
        ]);

        $cart = session('cart', []);
        $quantity = (int) ($validated['quantity'] ?? 1);
        $newQuantity = min(($cart[$product->id] ?? 0) + $quantity, $product->stock);

        $cart[$product->id] = $newQuantity;
        session(['cart' => $cart]);

        return back()->with('success', $product->name.' was added to your cart.');
    }

    public function updateCart(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'quantity' => ['required', 'integer', 'min:1', 'max:99'],
        ]);

        $product = Product::query()->findOrFail($validated['product_id']);
        abort_unless($product->isPurchasable(), 404);

        $cart = session('cart', []);
        if (array_key_exists($product->id, $cart)) {
            $cart[$product->id] = min((int) $validated['quantity'], $product->stock);
            session(['cart' => $cart]);
        }

        return back()->with('success', 'Cart quantity updated.');
    }

    public function removeFromCart(Product $product): RedirectResponse
    {
        $cart = session('cart', []);
        unset($cart[$product->id]);
        session(['cart' => $cart]);

        return back()->with('success', 'Item removed from your cart.');
    }

    public function clearCart(): RedirectResponse
    {
        session()->forget('cart');

        return back()->with('success', 'Cart cleared.');
    }

    public function cartCount(): int
    {
        return collect(session('cart', []))->sum();
    }

    public function cartTotal(): float
    {
        return (float) $this->cartItems()->sum('lineTotal');
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

            $quantity = min($quantity, $product->stock);
            return (object) [
                'product' => $product,
                'quantity' => $quantity,
                'lineTotal' => $product->currentPrice() * $quantity,
            ];
        })->filter()->values();
    }
}
