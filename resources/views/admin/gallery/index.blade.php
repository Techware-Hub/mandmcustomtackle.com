@extends('admin.layouts.app')
@section('page-title','Gallery / Portfolio')
@section('content')
<div class="mb-5 text-right"><a href="{{ route('admin.gallery.create') }}" class="rounded-lg bg-sky-500 px-4 py-3 font-bold text-slate-950">Add Gallery Item</a></div>
<div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">@forelse($items as $item)<div class="admin-card rounded-lg border border-slate-800 bg-slate-900 p-5"><div class="h-36 rounded-lg bg-slate-800">@if($item->image)<img src="{{ asset('storage/'.$item->image) }}" class="h-full w-full rounded-lg object-cover">@endif</div><h2 class="mt-4 font-black text-white">{{ $item->title }}</h2><p class="text-sm text-slate-400">{{ $item->category }} · {{ $item->status ?? 'active' }}</p><div class="mt-4 flex gap-3"><a href="{{ route('admin.gallery.edit', $item) }}" class="font-bold text-sky-300">Edit</a><form method="POST" action="{{ route('admin.gallery.destroy', $item) }}">@csrf @method('DELETE')<button class="font-bold text-red-300">Delete</button></form></div></div>@empty<p>No gallery items.</p>@endforelse</div><div class="mt-5">{{ $items->links() }}</div>
@endsection
