<div class="mx-auto max-w-3xl text-center reveal">
    @isset($eyebrow)
        <p class="text-sm font-bold uppercase tracking-wide text-sky-600">{{ $eyebrow }}</p>
    @endisset
    <h2 class="mt-2 text-3xl font-bold text-blue-950 md:text-4xl">{{ $title }}</h2>
    @isset($text)
        <p class="mt-4 text-base leading-7 text-slate-600">{{ $text }}</p>
    @endisset
</div>
