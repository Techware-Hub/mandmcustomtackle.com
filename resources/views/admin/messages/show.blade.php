@extends('admin.layouts.app')
@section('page-title','Message from '.$message->name)
@section('content')
<div class="admin-card rounded-lg border border-slate-800 bg-slate-900 p-6"><p class="text-sm text-slate-400">{{ $message->email }} · {{ $message->phone }} · {{ $message->created_at->format('M j, Y g:i A') }}</p><h2 class="mt-4 text-2xl font-black text-white">{{ $message->subject }}</h2><p class="mt-5 leading-7">{{ $message->message }}</p><form method="POST" action="{{ route('admin.messages.toggleRead', $message) }}" class="mt-6">@csrf @method('PUT')<button class="rounded-lg bg-sky-500 px-4 py-2 font-bold text-slate-950">Mark {{ $message->read_at ? 'Unread' : 'Read' }}</button></form></div>
@endsection
