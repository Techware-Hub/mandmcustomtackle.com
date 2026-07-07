<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductVariant;
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
        $product->load('variants');
        abort_unless($product->isPurchasable(), 404);

        $validated = $request->validate([
            'product_variant_id' => [$product->variants->isNotEmpty() ? 'required' : 'nullable', 'integer', 'exists:product_variants,id'],
            'quantity' => ['nullable', 'integer', 'min:1', 'max:99'],
        ], [
            'product_variant_id.required' => 'Please select color and weight before adding to cart.',
        ]);

        $cart = session('cart', []);
        $quantity = (int) ($validated['quantity'] ?? 1);
        $key = (string) $product->id;
        $stock = $product->stock;

        if ($product->variants->isNotEmpty()) {
            $variant = ProductVariant::query()->where('product_id', $product->id)->findOrFail($validated['product_variant_id']);

            if (! $variant->isPurchasable()) {
                return back()->withErrors(['product_variant_id' => 'Please select an active in-stock variant.'])->withInput();
            }

            $key = 'variant:'.$variant->id;
            $stock = $variant->stock;
        }

        $newQuantity = min(((int) ($cart[$key] ?? 0)) + $quantity, $stock);
        $cart[$key] = $newQuantity;
        session(['cart' => $cart]);

        return back()->with('success', $product->name.' was added to your cart.');
    }

    public function updateCart(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'cart_key' => ['required', 'string'],
            'quantity' => ['required', 'integer', 'min:1', 'max:99'],
        ]);

        $cart = session('cart', []);
        if (array_key_exists($validated['cart_key'], $cart)) {
            $cart[$validated['cart_key']] = (int) $validated['quantity'];
            session(['cart' => $cart]);
        }

        return back()->with('success', 'Cart quantity updated.');
    }

    public function removeFromCart(Request $request, Product $product): RedirectResponse
    {
        $cart = session('cart', []);
        unset($cart[$request->input('cart_key', (string) $product->id)]);
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
            ->mapWithKeys(fn ($quantity, $key) => [(string) $key => (int) $quantity])
            ->filter(fn ($quantity) => $quantity > 0);

        if ($cart->isEmpty()) {
            return collect();
        }

        $productIds = $cart->keys()->reject(fn ($key) => str_starts_with($key, 'variant:'))->map(fn ($key) => (int) $key);
        $variantIds = $cart->keys()->filter(fn ($key) => str_starts_with($key, 'variant:'))->map(fn ($key) => (int) substr($key, 8));

        $products = Product::query()
            ->with('category')
            ->whereIn('id', $productIds)
            ->where('status', 'active')
            ->get()
            ->keyBy('id');

        $variants = ProductVariant::query()
            ->with(['product.category'])
            ->whereIn('id', $variantIds)
            ->where('status', 'active')
            ->get()
            ->keyBy('id');

        return $cart->map(function ($quantity, $key) use ($products, $variants) {
            if (str_starts_with($key, 'variant:')) {
                $variant = $variants->get((int) substr($key, 8));
                if (! $variant || ! $variant->isPurchasable()) {
                    return null;
                }

                $quantity = min($quantity, $variant->stock);
                return (object) [
                    'cartKey' => $key,
                    'product' => $variant->product,
                    'variant' => $variant,
                    'quantity' => $quantity,
                    'unitPrice' => (float) $variant->price,
                    'lineTotal' => (float) $variant->price * $quantity,
                ];
            }

            $product = $products->get((int) $key);
            if (! $product || $product->stock <= 0) {
                return null;
            }

            $quantity = min($quantity, $product->stock);
            return (object) [
                'product' => $product,
                'variant' => null,
                'cartKey' => $key,
                'quantity' => $quantity,
                'unitPrice' => $product->currentPrice(),
                'lineTotal' => $product->currentPrice() * $quantity,
            ];
        })->filter()->values();
    }
}
