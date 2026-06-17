<a href="{{ route('products.index', ['category' => $category->slug]) }}" class="reveal group block rounded-lg border border-sky-100 bg-white p-6 shadow-sm transition duration-300 hover:-translate-y-1 hover:border-sky-300 hover:bg-sky-50 hover:shadow-xl hover:shadow-sky-100" data-aos="zoom-in" data-aos-duration="800">
    <div class="mb-5 h-24 overflow-hidden rounded-lg bg-gradient-to-br {{ $category->accent ?? 'from-sky-100 to-blue-400' }}">
        <div class="h-full w-full bg-white/20 transition duration-500 group-hover:scale-110 group-hover:bg-white/5"></div>
    </div>
    <h3 class="text-xl font-bold text-blue-950 group-hover:text-sky-600">{{ $category->name }}</h3>
    <p class="mt-2 text-sm leading-6 text-slate-600">{{ $category->description }}</p>
</a>
