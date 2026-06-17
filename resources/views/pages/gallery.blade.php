@extends('layouts.app')

@section('content')
<section class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
    <h1 class="text-4xl font-black text-blue-950 md:text-5xl">Portfolio Gallery</h1>
    <p class="mt-4 max-w-2xl leading-7 text-slate-700">Custom tackle work, jig heads, finished products, and customer photo placeholders.</p>
    <div class="gallery-filters mt-8 flex flex-wrap gap-3">
        @foreach (['All', 'Custom Jigs', 'Jig Heads', 'Customer Photos', 'Finished Products'] as $filter)
            <button type="button" data-filter="{{ $filter }}" class="rounded-full bg-white px-4 py-2 text-sm font-bold text-blue-950 shadow-sm transition hover:bg-sky-100">{{ $filter }}</button>
        @endforeach
    </div>
    <div class="mt-10 columns-1 gap-6 sm:columns-2 lg:columns-3">
        @foreach ($items as $item)
            <div class="mb-6 break-inside-avoid">
                <x-gallery-card :item="$item" />
            </div>
        @endforeach
    </div>
</section>
@endsection
