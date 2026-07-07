@extends('layouts.app')

@section('content')
<section class="mx-auto grid max-w-7xl gap-10 px-4 py-14 sm:px-6 lg:grid-cols-2 lg:px-8">
    <div class="reveal rounded-lg border border-sky-100 bg-white p-5 shadow-sm">
        <div class="overflow-hidden rounded-lg">
            <x-product-image :product="$product" variant="detail" />
        </div>
    </div>
    <div class="reveal">
        <span class="rounded-full bg-sky-50 px-3 py-1 text-sm font-bold text-sky-700">{{ $product->category->name }}</span>
        <h1 class="mt-5 text-4xl font-black text-blue-950">{{ $product->name }}</h1>
        @php
            $activeVariants = $product->variants->where('status', 'active')->values();
            $firstVariant = $activeVariants->first();
            $variantPayload = $activeVariants->map(fn ($variant) => [
                'id' => $variant->id,
                'color' => $variant->color_name,
                'weight' => $variant->weight,
                'price' => (float) $variant->price,
                'stock' => $variant->stock,
            ])->values();
        @endphp
        <p class="mt-3 text-3xl font-black text-sky-700" data-product-price>{{ $firstVariant ? 'Starting from ' : '' }}${{ number_format((float) ($firstVariant->price ?? $product->price), 2) }}</p>
        <p class="mt-3 text-lg font-bold text-blue-950">{{ $product->short_description }}</p>
        <p class="mt-5 leading-8 text-slate-700">{{ $product->description }}</p>
        <p class="mt-3 text-sm font-bold text-slate-600" data-product-stock>{{ $firstVariant ? $firstVariant->stock.' in stock' : $product->stock.' in stock' }}</p>
        <form method="POST" action="{{ route('cart.add', $product) }}" class="mt-8 max-w-xl" data-variant-form>
            @csrf
            @if($activeVariants->isNotEmpty())
                <input type="hidden" name="product_variant_id" value="{{ old('product_variant_id', $firstVariant->id) }}" data-variant-input>
                <div class="grid gap-5 rounded-lg border border-sky-100 bg-white p-5 shadow-sm">
                    <div>
                        <p class="text-sm font-bold text-slate-700">Color</p>
                        <div class="mt-3 flex flex-wrap gap-2" data-color-options>
                            @foreach($activeVariants->pluck('color_name')->unique() as $color)
                                <button type="button" data-color="{{ $color }}" class="rounded-lg border border-sky-200 px-3 py-2 text-sm font-bold text-blue-950 transition hover:border-sky-500 hover:bg-sky-50">{{ $color }}</button>
                            @endforeach
                        </div>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-slate-700">Weight / Size</p>
                        <div class="mt-3 flex flex-wrap gap-2" data-weight-options>
                            @foreach($activeVariants->pluck('weight')->unique() as $weight)
                                <button type="button" data-weight="{{ $weight }}" class="rounded-lg border border-sky-200 px-3 py-2 text-sm font-bold text-blue-950 transition hover:border-sky-500 hover:bg-sky-50">{{ $weight }}</button>
                            @endforeach
                        </div>
                    </div>
                    @error('product_variant_id')<span class="text-sm font-bold text-red-600">{{ $message }}</span>@enderror
                </div>
            @endif
            <div class="mt-4 flex max-w-md gap-3">
                <input type="number" name="quantity" value="1" min="1" max="{{ $firstVariant->stock ?? $product->stock }}" class="w-24 rounded-lg border border-sky-200 px-3 py-3" data-quantity-input>
                <button class="flex-1 rounded-lg bg-blue-950 px-6 py-3 font-bold text-white transition hover:bg-sky-700">Add to Cart</button>
            </div>
        </form>
        <div class="mt-8 rounded-lg border border-sky-100 bg-white p-6">
            <h2 class="text-xl font-bold text-blue-950">Product Specifications</h2>
            <ul class="mt-4 grid gap-2 text-sm text-slate-700">
                @foreach ($product->specs ?? [] as $spec)
                    <li class="rounded-lg bg-sky-50 px-3 py-2">{{ $spec }}</li>
                @endforeach
            </ul>
        </div>
    </div>
</section>
<section class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
    <div class="grid gap-8 lg:grid-cols-[1fr_2fr]">
        <div class="reveal rounded-lg border border-sky-100 bg-white p-6 shadow-sm">
            <h2 class="text-2xl font-bold text-blue-950">Customer Reviews</h2>
            <p class="mt-3 font-bold text-amber-500">5/5 stars</p>
            <p class="mt-3 leading-7 text-slate-700">Clean finish, strong action, and exactly the kind of tackle I want in my saltwater box.</p>
        </div>
        <div>
            <h2 class="mb-6 text-2xl font-bold text-blue-950">Related Products</h2>
            <div class="grid gap-6 md:grid-cols-3">
                @foreach ($related as $item)
                    <x-product-card :product="$item" />
                @endforeach
            </div>
        </div>
    </div>
</section>
@if($activeVariants->isNotEmpty())
<script>
(() => {
    const variants = @json($variantPayload);
    const form = document.querySelector('[data-variant-form]');
    const input = form?.querySelector('[data-variant-input]');
    const price = document.querySelector('[data-product-price]');
    const stock = document.querySelector('[data-product-stock]');
    const quantity = form?.querySelector('[data-quantity-input]');
    const colorButtons = [...document.querySelectorAll('[data-color]')];
    const weightButtons = [...document.querySelectorAll('[data-weight]')];
    let selectedColor = variants[0]?.color;
    let selectedWeight = variants[0]?.weight;

    const money = new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' });
    const paint = () => {
        const variant = variants.find(item => item.color === selectedColor && item.weight === selectedWeight);
        colorButtons.forEach(button => button.classList.toggle('bg-sky-100', button.dataset.color === selectedColor));
        weightButtons.forEach(button => button.classList.toggle('bg-sky-100', button.dataset.weight === selectedWeight));
        if (!variant) {
            input.value = '';
            stock.textContent = 'Variant unavailable';
            return;
        }
        input.value = variant.id;
        price.textContent = money.format(variant.price);
        stock.textContent = `${variant.stock} in stock`;
        quantity.max = variant.stock;
    };

    colorButtons.forEach(button => button.addEventListener('click', () => {
        selectedColor = button.dataset.color;
        const matching = variants.find(item => item.color === selectedColor && item.weight === selectedWeight) || variants.find(item => item.color === selectedColor);
        selectedWeight = matching?.weight;
        paint();
    }));

    weightButtons.forEach(button => button.addEventListener('click', () => {
        selectedWeight = button.dataset.weight;
        paint();
    }));

    form.addEventListener('submit', event => {
        if (!input.value) {
            event.preventDefault();
            stock.textContent = 'Please select an available color and weight.';
        }
    });

    paint();
})();
</script>
@endif
@endsection
