@extends('layouts.app')

@section('content')
<section class="mx-auto grid max-w-7xl gap-10 px-4 py-16 sm:px-6 lg:grid-cols-2 lg:px-8">
    <div class="reveal">
        <p class="text-sm font-bold uppercase tracking-wide text-sky-600">About M&M Custom Tackle</p>
        <h1 class="mt-2 text-4xl font-black text-blue-950 md:text-5xl">Handcrafted tackle from Sarasota, Florida</h1>
        <p class="mt-6 leading-8 text-slate-700">M&M Custom Tackle is owned by Mark Scaperotta and focused on clean, practical fishing products for anglers who want dependable performance. The shop specializes in custom jigs, jig heads, bucktail jigs, specialty tackle, accessories, and fishing apparel.</p>
        <p class="mt-4 leading-8 text-slate-700">The goal is simple: help customers find tackle they can trust, customize, and take straight to the water with confidence.</p>
    </div>
    <div class="reveal rounded-lg bg-gradient-to-br from-sky-100 to-blue-500 p-8 shadow-xl">
        <img src="{{ asset('assets/logo/logo.jpg') }}" alt="M&M Custom Tackle logo" class="mx-auto h-40 w-40 rounded-full object-cover ring-4 ring-white">
        <div class="mt-8 rounded-lg bg-white/90 p-6">
            <h2 class="text-2xl font-bold text-blue-950">Business Details</h2>
            <div class="mt-4 space-y-2 text-slate-700">
                <p>Owner: Mark Scaperotta</p>
                <p>Email: Mandmcustomtackle@gmail.com</p>
                <p>Phone: (941) 544-1066</p>
                <p>Location: Sarasota, Florida</p>
            </div>
        </div>
    </div>
</section>
@endsection
