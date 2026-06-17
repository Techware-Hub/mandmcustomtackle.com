<article class="reveal group flex h-full flex-col overflow-hidden rounded-lg border border-sky-100 bg-white shadow-sm transition duration-300 hover:-translate-y-1 hover:border-sky-300 hover:shadow-xl hover:shadow-sky-100" data-aos="fade-up" data-aos-duration="800">
    <a href="{{ route('products.show', $product->slug) }}" class="block overflow-hidden">
        <div class="flex aspect-[4/3] items-center justify-center bg-gradient-to-br {{ $product->color ?? 'from-sky-100 to-blue-300' }} transition duration-500 group-hover:scale-105">
            <div class="h-20 w-40 rounded-full border-4 border-white/80 bg-white/30 shadow-inner transition duration-500 group-hover:scale-110"></div>
        </div>
    </a>
    <div class="flex flex-1 flex-col p-5">
        <div class="flex items-center justify-between gap-3">
            <span class="rounded-full bg-sky-50 px-3 py-1 text-xs font-bold text-sky-700">{{ $product->category->name }}</span>
            <span class="text-lg font-black text-blue-950">${{ number_format((float) $product->price, 2) }}</span>
        </div>
        <h3 class="mt-4 text-xl font-bold text-blue-950"><a href="{{ route('products.show', $product->slug) }}">{{ $product->name }}</a></h3>
        <p class="mt-2 flex-1 text-sm leading-6 text-slate-600">{{ $product->short_description ?? $product->description }}</p>
        <div class="mt-4 text-sm font-bold text-amber-500" aria-label="{{ $product->rating ?? 5 }} out of 5 stars">{{ $product->rating ?? 5 }}/5 stars</div>
        <div class="mt-5 grid grid-cols-2 gap-3">
            @if (isset($product->id))
                <form method="POST" action="{{ route('cart.add', $product) }}">
                    @csrf
                    <button class="w-full rounded-lg bg-sky-500 px-4 py-2 text-sm font-bold text-white transition duration-300 hover:scale-[1.02] hover:bg-blue-700">Add to Cart</button>
                </form>
            @else
                <a href="{{ route('products.show', $product->slug) }}" class="rounded-lg bg-sky-500 px-4 py-2 text-center text-sm font-bold text-white transition duration-300 hover:scale-[1.02] hover:bg-blue-700">View Product</a>
            @endif
            <a href="{{ route('products.show', $product->slug) }}" class="rounded-lg border border-sky-200 px-4 py-2 text-center text-sm font-bold text-blue-950 transition duration-300 hover:scale-[1.02] hover:bg-sky-50">Details</a>
        </div>
    </div>
</article>
