<article class="gallery-item reveal group overflow-hidden rounded-lg border border-sky-100 bg-white shadow-sm transition duration-300 hover:-translate-y-1 hover:border-sky-300 hover:shadow-xl hover:shadow-sky-100" data-category="{{ $item->category }}" data-aos="fade-up" data-aos-duration="800">
    <div class="relative flex aspect-[4/3] items-center justify-center overflow-hidden bg-gradient-to-br {{ $item->color ?? 'from-sky-100 to-blue-400' }}">
        <div class="h-24 w-24 rounded-full border-4 border-white/80 bg-white/30 transition duration-500 group-hover:scale-125"></div>
        <div class="absolute inset-0 flex items-end bg-sky-900/0 p-5 opacity-0 transition duration-300 group-hover:bg-sky-900/45 group-hover:opacity-100">
            <div class="translate-y-3 transition duration-300 group-hover:translate-y-0">
                <p class="text-xs font-bold uppercase tracking-wide text-sky-100">{{ $item->category }}</p>
                <p class="mt-1 font-bold text-white">{{ $item->title }}</p>
            </div>
        </div>
    </div>
    <div class="p-5">
        <span class="text-xs font-bold uppercase tracking-wide text-sky-600">{{ $item->category }}</span>
        <h3 class="mt-2 text-lg font-bold text-blue-950">{{ $item->title }}</h3>
        <p class="mt-2 text-sm leading-6 text-slate-600">{{ $item->description }}</p>
    </div>
</article>
