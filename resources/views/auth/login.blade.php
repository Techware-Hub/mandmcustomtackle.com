@extends('layouts.app')

@section('content')
<section class="mx-auto max-w-md px-4 py-14 sm:px-6 lg:px-8">
    <div class="rounded-lg border border-sky-100 bg-white p-6 shadow-sm">
        <h1 class="text-3xl font-black text-blue-950">Customer Login</h1>
        <p class="mt-3 text-sm leading-6 text-slate-600">TODO: Connect this page to Laravel authentication scaffolding when customer accounts are enabled.</p>
        <form class="mt-6 grid gap-4">
            <input type="email" placeholder="Email" class="rounded-lg border border-sky-200 px-3 py-3">
            <input type="password" placeholder="Password" class="rounded-lg border border-sky-200 px-3 py-3">
            <button type="button" class="rounded-lg bg-blue-950 px-5 py-3 font-bold text-white">Login</button>
        </form>
        <a href="{{ route('register') }}" class="mt-5 inline-block text-sm font-bold text-sky-700">Create an account</a>
    </div>
</section>
@endsection
