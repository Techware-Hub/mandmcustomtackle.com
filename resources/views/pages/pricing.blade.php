@extends('layouts.app')

@section('content')
<section class="mx-auto max-w-7xl px-4 py-14 sm:px-6 lg:px-8">
    <x-section-title eyebrow="Pricing" title="Simple package options for custom tackle" text="Use these packages as starting points for client review and custom order conversations." />
    <div class="mt-10 grid gap-6 md:grid-cols-2 lg:grid-cols-4">
        @foreach ([['Starter Tackle Pack', '$24+', 'A small ready-to-fish mix for trying M&M products.'], ['Custom Jig Pack', '$42+', 'Multiple custom jigs with color and weight options.'], ['Pro Angler Pack', '$75+', 'A broader set for frequent inshore and surf fishing.'], ['Bulk / Custom Order', 'Quote', 'Custom quantities, colors, materials, and package requests.']] as [$name, $price, $text])
            <article class="reveal rounded-lg border border-sky-100 bg-white p-6 shadow-sm">
                <h2 class="text-xl font-bold text-blue-950">{{ $name }}</h2>
                <p class="mt-4 text-3xl font-black text-sky-700">{{ $price }}</p>
                <p class="mt-4 text-sm leading-6 text-slate-600">{{ $text }}</p>
                <a href="{{ route('contact') }}" class="mt-6 inline-block rounded-lg bg-blue-950 px-5 py-3 text-sm font-bold text-white">Request Pricing</a>
            </article>
        @endforeach
    </div>
    <p class="reveal mt-8 rounded-lg bg-sky-100 p-5 text-center font-semibold text-blue-950">Final pricing may vary based on product type, quantity, color, material, and custom requirements.</p>
</section>
@endsection
