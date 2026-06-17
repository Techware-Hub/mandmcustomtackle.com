@extends('layouts.app')

@section('content')
<section class="mx-auto grid max-w-7xl gap-10 px-4 py-14 sm:px-6 lg:grid-cols-[.8fr_1.2fr] lg:px-8">
    <div class="reveal">
        <p class="text-sm font-bold uppercase tracking-wide text-sky-600">Contact Us</p>
        <h1 class="mt-2 text-4xl font-black text-blue-950 md:text-5xl">Need custom tackle?</h1>
        <p class="mt-5 leading-8 text-slate-700">Send us a message and we'll help you choose the right setup.</p>
        <div class="mt-8 rounded-lg border border-sky-100 bg-white p-6 shadow-sm">
            <h2 class="text-2xl font-bold text-blue-950">M&M Custom Tackle</h2>
            <div class="mt-4 space-y-3 text-slate-700">
                <p>Email: <a href="mailto:Mandmcustomtackle@gmail.com" class="font-bold text-sky-700">Mandmcustomtackle@gmail.com</a></p>
                <p>Phone: <a href="tel:+19415441066" class="font-bold text-sky-700">(941) 544-1066</a></p>
                <p>Location: Sarasota, Florida</p>
            </div>
        </div>
    </div>
    <form method="POST" action="{{ route('contact.store') }}" class="reveal rounded-lg border border-sky-100 bg-white p-6 shadow-sm">
        @csrf
        <div class="grid gap-4 md:grid-cols-2">
            @foreach ([['name','Name'], ['email','Email'], ['phone','Phone'], ['subject','Subject']] as [$name, $label])
                <label>
                    <span class="text-sm font-bold text-slate-700">{{ $label }}</span>
                    <input name="{{ $name }}" value="{{ old($name) }}" class="mt-2 w-full rounded-lg border border-sky-200 px-3 py-3" {{ $name === 'phone' ? '' : 'required' }}>
                    @error($name)<span class="mt-1 block text-sm text-red-600">{{ $message }}</span>@enderror
                </label>
            @endforeach
            <label class="md:col-span-2">
                <span class="text-sm font-bold text-slate-700">Message</span>
                <textarea name="message" rows="6" class="mt-2 w-full rounded-lg border border-sky-200 px-3 py-3" required>{{ old('message') }}</textarea>
                @error('message')<span class="mt-1 block text-sm text-red-600">{{ $message }}</span>@enderror
            </label>
        </div>
        <button class="mt-6 rounded-lg bg-blue-950 px-6 py-3 font-bold text-white transition hover:bg-sky-700">Send Message</button>
    </form>
</section>
@endsection
