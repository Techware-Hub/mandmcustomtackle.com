@props([
    'product' => null,
    'name' => null,
    'variant' => 'card',
])

@php
    $displayName = $name ?? ($product->name ?? 'Product');
    $imagePath = $product->image ?? null;
    $imageUrl = null;

    if ($imagePath) {
        if (str_starts_with($imagePath, 'assets/') && file_exists(public_path($imagePath))) {
            $imageUrl = asset($imagePath);
        } elseif (str_starts_with($imagePath, 'storage/') && file_exists(public_path($imagePath))) {
            $imageUrl = asset($imagePath);
        } elseif (file_exists(public_path('storage/'.$imagePath))) {
            $imageUrl = asset('storage/'.$imagePath);
        } elseif (file_exists(public_path($imagePath))) {
            $imageUrl = asset($imagePath);
        }
    }

    $classes = [
        'card' => 'h-44 w-full sm:h-56',
        'detail' => 'aspect-square w-full',
        'cart' => 'h-24 w-24',
        'summary' => 'h-14 w-14',
        'thumb' => 'h-12 w-12',
    ][$variant] ?? 'h-44 w-full';

    $rounded = $variant === 'card' ? 'rounded-t-lg' : 'rounded-lg';
@endphp

@if ($imageUrl)
    <img src="{{ $imageUrl }}" alt="{{ $displayName }}" loading="lazy" {{ $attributes->merge(['class' => $classes.' '.$rounded.' bg-sky-50 object-cover shadow-sm transition duration-500 group-hover:scale-105']) }}>
@else
    <div {{ $attributes->merge(['class' => $classes.' '.$rounded.' grid place-items-center bg-gradient-to-br from-sky-50 via-white to-cyan-100 p-3 text-center shadow-sm transition duration-500 group-hover:scale-105']) }}>
        <div class="rounded-lg border border-sky-100 bg-white/70 px-3 py-2">
            <p class="text-xs font-black uppercase tracking-wide text-sky-700">Fishing Tackle</p>
            <p class="mt-1 font-black text-blue-950">{{ $displayName }}</p>
            <p class="mt-1 text-xs font-bold text-slate-500">Image Coming Soon</p>
        </div>
    </div>
@endif
