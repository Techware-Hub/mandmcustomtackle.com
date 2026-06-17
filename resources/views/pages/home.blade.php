@extends('layouts.app')

@section('content')
<section class="relative overflow-hidden bg-gradient-to-br from-white via-sky-100 to-cyan-200" data-slider>
    <div class="absolute inset-x-0 bottom-0 h-20 bg-white" style="clip-path: polygon(0 45%, 20% 70%, 45% 50%, 70% 75%, 100% 45%, 100% 100%, 0 100%)"></div>
    <div class="slider-viewport relative flex snap-x snap-mandatory overflow-x-auto scroll-smooth" data-slider-viewport>
        @foreach ([['Custom Tackle Built for Serious Anglers', 'Handcrafted fishing tackle from Sarasota, Florida, made for performance, durability, and confidence on the water.'], ['Built for Saltwater Performance', 'Quality tackle designed for strength, durability, and confidence in Florida saltwater conditions.'], ['Shop Custom Fishing Gear', 'Browse jigs, jig heads, accessories, apparel, and specialty tackle built for serious anglers.']] as [$headline, $subtext])
            <div class="min-w-full snap-start" data-slider-card>
                <div class="relative mx-auto grid max-w-7xl gap-10 px-4 py-16 sm:px-6 lg:grid-cols-[1.05fr_.95fr] lg:px-8 lg:py-24">
                    <div class="flex flex-col justify-center" data-aos="fade-right">
                        <img src="{{ asset('assets/logo/logo.jpg') }}" alt="M&M Custom Tackle logo" class="mb-6 h-20 w-20 rounded-full object-cover ring-4 ring-white">
                        <h1 class="max-w-3xl text-4xl font-black leading-tight text-blue-950 md:text-6xl">{{ $headline }}</h1>
                        <p class="mt-6 max-w-2xl text-lg leading-8 text-slate-700">{{ $subtext }}</p>
                        <div class="mt-8 flex flex-wrap gap-4" data-aos="fade-up" data-aos-delay="150">
                            <a href="{{ route('products.index') }}" class="rounded-lg bg-blue-950 px-6 py-3 font-bold text-white shadow-lg transition duration-300 hover:scale-[1.03] hover:bg-sky-700 hover:shadow-xl">Shop Products</a>
                            <a href="{{ route('gallery') }}" class="rounded-lg border border-sky-300 bg-white px-6 py-3 font-bold text-blue-950 transition duration-300 hover:scale-[1.03] hover:bg-sky-50 hover:shadow-lg">View Gallery</a>
                        </div>
                    </div>
                    <div class="grid content-center gap-4" data-aos="fade-left" data-aos-delay="100">
                        <div class="rounded-lg border border-white/80 bg-white/80 p-5 shadow-xl transition duration-300 hover:-translate-y-1 hover:shadow-2xl">
                            <div class="aspect-[4/3] overflow-hidden rounded-lg bg-gradient-to-br from-sky-200 via-white to-blue-500 p-6">
                                <div class="flex h-full items-center justify-center rounded-lg border-2 border-white/70 bg-white/30">
                                    <div class="h-20 w-52 rounded-full bg-blue-950/15 shadow-inner transition duration-500 hover:scale-110"></div>
                                </div>
                            </div>
                            <div class="mt-5 grid grid-cols-3 gap-3 text-center text-sm font-bold text-blue-950">
                                <span class="rounded-lg bg-sky-50 py-3">Custom Jigs</span>
                                <span class="rounded-lg bg-sky-50 py-3">Saltwater</span>
                                <span class="rounded-lg bg-sky-50 py-3">Sarasota</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="absolute bottom-8 left-1/2 z-10 flex -translate-x-1/2 items-center gap-3">
        <button type="button" class="rounded-full bg-white/90 p-2 text-blue-950 shadow transition hover:scale-110 hover:bg-white" data-slider-prev aria-label="Previous hero slide">&lsaquo;</button>
        @for ($i = 0; $i < 3; $i++)
            <button type="button" class="h-2.5 w-2.5 rounded-full bg-sky-200 transition" data-slider-dot aria-label="Hero slide {{ $i + 1 }}"></button>
        @endfor
        <button type="button" class="rounded-full bg-white/90 p-2 text-blue-950 shadow transition hover:scale-110 hover:bg-white" data-slider-next aria-label="Next hero slide">&rsaquo;</button>
    </div>
</section>

<section class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8" data-aos="fade-up">
    <x-section-title eyebrow="Shop by Category" title="Fishing tackle made easy to browse" text="Choose from custom jigs, jig heads, bucktails, accessories, and more." />
    <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
        @foreach ($categories as $category)
            <x-category-card :category="$category" />
        @endforeach
    </div>
</section>

<section class="bg-white py-16">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8" data-slider>
        <x-section-title eyebrow="Best Sellers" title="Ready for your next trip" text="Popular products and starter picks for Sarasota-area saltwater fishing." />
        <div class="mt-8 flex justify-end gap-3">
            <button type="button" class="rounded-full border border-sky-200 bg-white px-4 py-2 font-bold text-blue-950 transition hover:scale-105 hover:bg-sky-50" data-slider-prev aria-label="Previous products">&lsaquo;</button>
            <button type="button" class="rounded-full border border-sky-200 bg-white px-4 py-2 font-bold text-blue-950 transition hover:scale-105 hover:bg-sky-50" data-slider-next aria-label="Next products">&rsaquo;</button>
        </div>
        <div class="slider-viewport mt-6 flex snap-x snap-mandatory gap-6 overflow-x-auto scroll-smooth pb-4" data-slider-viewport>
            @foreach ($products as $product)
                <div class="min-w-full snap-start sm:min-w-[calc(50%-12px)] lg:min-w-[calc(25%-18px)]" data-slider-card>
                    <x-product-card :product="$product" />
                </div>
            @endforeach
        </div>
    </div>
</section>

<section class="mx-auto grid max-w-7xl gap-8 px-4 py-16 sm:px-6 lg:grid-cols-3 lg:px-8">
    @foreach ([['Built Local', 'Designed around Florida saltwater fishing conditions.'], ['Handmade Quality', 'Small-batch care, clean finishes, and practical color choices.'], ['Custom Orders', 'Need a specific color, weight, or profile? Ask Mark for options.']] as [$title, $text])
        <div class="reveal rounded-lg border border-sky-100 bg-white p-8 shadow-sm transition duration-300 hover:-translate-y-1 hover:border-sky-300 hover:shadow-xl" data-aos="flip-up" data-aos-delay="{{ $loop->index * 100 }}">
            <h2 class="text-2xl font-bold text-blue-950">{{ $title }}</h2>
            <p class="mt-3 leading-7 text-slate-600">{{ $text }}</p>
        </div>
    @endforeach
</section>

<section class="bg-gradient-to-br from-blue-950 to-sky-800 py-16 text-white">
    <div class="mx-auto grid max-w-7xl gap-10 px-4 sm:px-6 lg:grid-cols-2 lg:px-8">
        <div class="reveal" data-aos="fade-right">
            <p class="text-sm font-bold uppercase tracking-wide text-sky-200">Handmade Quality</p>
            <h2 class="mt-2 text-3xl font-bold md:text-4xl">Custom tackle with a practical fishing-first mindset</h2>
        </div>
        <p class="reveal text-lg leading-8 text-sky-100" data-aos="fade-left" data-aos-delay="100">Every product starts with real fishing use in mind: weight, profile, flash, durability, and the confidence to cast near structure. The result is a clean, professional tackle lineup ready for client review and future online sales.</p>
    </div>
</section>

<section class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8" data-slider>
    <x-section-title eyebrow="Gallery" title="Custom work and finished products" />
    <div class="mt-8 flex justify-end gap-3">
        <button type="button" class="rounded-full border border-sky-200 bg-white px-4 py-2 font-bold text-blue-950 transition hover:scale-105 hover:bg-sky-50" data-slider-prev aria-label="Previous gallery">&lsaquo;</button>
        <button type="button" class="rounded-full border border-sky-200 bg-white px-4 py-2 font-bold text-blue-950 transition hover:scale-105 hover:bg-sky-50" data-slider-next aria-label="Next gallery">&rsaquo;</button>
    </div>
    <div class="slider-viewport mt-6 flex snap-x snap-mandatory gap-6 overflow-x-auto scroll-smooth pb-4" data-slider-viewport>
        @foreach ($galleryItems as $item)
            <div class="min-w-full snap-start sm:min-w-[calc(50%-12px)] lg:min-w-[calc(33.333%-16px)]" data-slider-card>
                <x-gallery-card :item="$item" />
            </div>
        @endforeach
    </div>
</section>

<section class="bg-white py-16">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8" data-slider>
        <x-section-title eyebrow="Reviews" title="Trusted by local anglers" />
        <div class="mt-8 flex justify-end gap-3">
            <button type="button" class="rounded-full border border-sky-200 bg-white px-4 py-2 font-bold text-blue-950 transition hover:scale-105 hover:bg-sky-50" data-slider-prev aria-label="Previous testimonials">&lsaquo;</button>
            <button type="button" class="rounded-full border border-sky-200 bg-white px-4 py-2 font-bold text-blue-950 transition hover:scale-105 hover:bg-sky-50" data-slider-next aria-label="Next testimonials">&rsaquo;</button>
        </div>
        <div class="slider-viewport mt-6 flex snap-x snap-mandatory gap-6 overflow-x-auto scroll-smooth pb-4" data-slider-viewport>
            @foreach ($testimonials as $testimonial)
                <div class="min-w-full snap-start md:min-w-[calc(50%-12px)] lg:min-w-[calc(33.333%-16px)]" data-slider-card>
                    <x-testimonial-card :testimonial="$testimonial" />
                </div>
            @endforeach
        </div>
    </div>
</section>

<section class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
    <x-section-title eyebrow="Fishing Notes" title="Tips from the tackle bench" />
    <div class="mt-10 grid gap-6 md:grid-cols-3">
        @foreach ($posts as $post)
            <article class="reveal group rounded-lg border border-sky-100 bg-white p-6 shadow-sm transition duration-300 hover:-translate-y-1 hover:border-sky-300 hover:shadow-xl" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                <div class="mb-5 h-24 overflow-hidden rounded-lg bg-gradient-to-br from-sky-100 to-blue-400">
                    <div class="h-full w-full bg-white/20 transition duration-500 group-hover:scale-110"></div>
                </div>
                <h3 class="text-xl font-bold text-blue-950">{{ $post->title }}</h3>
                <p class="mt-3 text-sm leading-6 text-slate-600">{{ $post->excerpt }}</p>
                <a href="{{ route('blog.show', $post->slug) }}" class="mt-5 inline-block font-bold text-sky-700 transition group-hover:translate-x-1">Read More</a>
            </article>
        @endforeach
    </div>
</section>

<section class="mx-auto max-w-7xl px-4 pb-16 sm:px-6 lg:px-8">
    <div class="reveal rounded-lg bg-sky-500 p-8 text-center text-white shadow-xl transition duration-300 hover:-translate-y-1 hover:shadow-2xl md:p-12" data-aos="zoom-in">
        <h2 class="text-3xl font-bold">Need custom tackle?</h2>
        <p class="mx-auto mt-3 max-w-2xl text-sky-50">Send us a message and we'll help you choose the right setup.</p>
        <a href="{{ route('contact') }}" class="mt-6 inline-block rounded-lg bg-white px-6 py-3 font-bold text-blue-950 transition duration-300 hover:scale-[1.03] hover:bg-sky-50">Contact M&M</a>
    </div>
</section>
@endsection
