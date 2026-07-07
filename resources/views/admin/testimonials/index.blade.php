@extends('admin.layouts.app')
@section('page-title','Testimonials')
@section('content')
<div class="mb-5 text-right"><a href="{{ route('admin.testimonials.create') }}" class="rounded-lg bg-sky-500 px-4 py-3 font-bold text-slate-950">Add Testimonial</a></div>
<div class="grid gap-4 lg:grid-cols-2">@forelse($testimonials as $testimonial)<div class="admin-card rounded-lg border border-slate-800 bg-slate-900 p-5"><h2 class="font-black text-white">{{ $testimonial->name }}</h2><p class="text-sm text-slate-400">{{ $testimonial->location }} · {{ $testimonial->rating ?? 5 }}/5 · {{ $testimonial->status ?? 'active' }}</p><p class="mt-3">{{ $testimonial->quote }}</p><div class="mt-4 flex gap-3"><a href="{{ route('admin.testimonials.edit', $testimonial) }}" class="font-bold text-sky-300">Edit</a><form method="POST" action="{{ route('admin.testimonials.destroy', $testimonial) }}">@csrf @method('DELETE')<button class="font-bold text-red-300">Delete</button></form></div></div>@empty<p>No testimonials.</p>@endforelse</div><div class="mt-5">{{ $testimonials->links() }}</div>
@endsection
