@extends('layouts.app')

@section('content')
<section class="mx-auto max-w-6xl px-4 py-14 sm:px-6 lg:px-8">
    <h1 class="text-4xl font-black text-blue-950">Checkout</h1>
    <form method="POST" action="{{ route('checkout.placeOrder') }}" class="mt-8 grid gap-8 lg:grid-cols-[1fr_380px]">
        @csrf
        <div class="rounded-lg border border-sky-100 bg-white p-6 shadow-sm">
            <h2 class="text-2xl font-bold text-blue-950">Shipping Details</h2>
            <div class="mt-6 grid gap-4 md:grid-cols-2">
                @foreach ([['name','Name'], ['email','Email'], ['phone','Phone'], ['address','Shipping Address'], ['city','City'], ['state','State'], ['zip','ZIP Code']] as [$name, $label])
                    <label class="{{ $name === 'address' ? 'md:col-span-2' : '' }}">
                        <span class="text-sm font-bold text-slate-700">{{ $label }}</span>
                        <input name="{{ $name }}" value="{{ old($name) }}" class="mt-2 w-full rounded-lg border border-sky-200 px-3 py-3" required>
                        @error($name)<span class="mt-1 block text-sm text-red-600">{{ $message }}</span>@enderror
                    </label>
                @endforeach
                <label class="md:col-span-2">
                    <span class="text-sm font-bold text-slate-700">Order Notes</span>
                    <textarea name="notes" rows="4" class="mt-2 w-full rounded-lg border border-sky-200 px-3 py-3">{{ old('notes') }}</textarea>
                    @error('notes')<span class="mt-1 block text-sm text-red-600">{{ $message }}</span>@enderror
                </label>
            </div>
        </div>
        <aside class="h-fit rounded-lg border border-sky-100 bg-white p-6 shadow-sm">
            <h2 class="text-2xl font-bold text-blue-950">Payment</h2>
            <label class="mt-5 block">
                <span class="text-sm font-bold text-slate-700">Payment Method</span>
                <select name="payment_method" class="mt-2 w-full rounded-lg border border-sky-200 px-3 py-3">
                    <option value="cash_on_delivery" @selected(old('payment_method') === 'cash_on_delivery')>Cash on Delivery / Pay Later</option>
                    <option value="manual_payment" @selected(old('payment_method') === 'manual_payment')>Manual Payment</option>
                    <option value="card_placeholder" @selected(old('payment_method') === 'card_placeholder')>Card Payment Placeholder</option>
                </select>
                @error('payment_method')<span class="mt-1 block text-sm text-red-600">{{ $message }}</span>@enderror
            </label>
            <p class="mt-4 rounded-lg bg-amber-50 p-3 text-sm text-amber-800">TODO: Connect Stripe or PayPal when payment credentials and preferred provider are available.</p>
            <div class="mt-5 space-y-3 border-b border-sky-100 pb-5 text-sm text-slate-700">
                @foreach ($cartItems as $item)
                    <div class="flex justify-between gap-4">
                        <span>{{ $item->product->name }} x {{ $item->quantity }}</span>
                        <strong>${{ number_format($item->lineTotal, 2) }}</strong>
                    </div>
                @endforeach
            </div>
            <div class="mt-5 space-y-3 text-slate-700">
                <div class="flex justify-between"><span>Subtotal</span><strong>${{ number_format($subtotal, 2) }}</strong></div>
                <div class="flex justify-between"><span>Shipping</span><strong>${{ number_format($shipping, 2) }}</strong></div>
                <div class="flex justify-between"><span>Tax</span><strong>${{ number_format($tax, 2) }}</strong></div>
                <div class="border-t border-sky-100 pt-3 flex justify-between text-lg text-blue-950"><span>Total</span><strong>${{ number_format($subtotal + $shipping + $tax, 2) }}</strong></div>
            </div>
            <button class="mt-6 w-full rounded-lg bg-blue-950 px-5 py-3 font-bold text-white transition hover:bg-sky-700">Place Order</button>
        </aside>
    </form>
</section>
@endsection
