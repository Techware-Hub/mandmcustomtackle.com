@extends('layouts.app')

@section('content')
<section class="mx-auto max-w-md px-4 py-14 sm:px-6 lg:px-8">
    <div class="rounded-lg border border-sky-100 bg-white p-6 shadow-sm">
        <h1 class="text-3xl font-black text-blue-950">Create Account</h1>
        <p class="mt-3 text-sm leading-6 text-slate-600">Create a customer account for faster checkout and order history.</p>
        <form method="POST" action="{{ route('register.store') }}" class="mt-6 grid gap-4">
            @csrf
            <label>
                <span class="text-sm font-bold text-slate-700">Name</span>
                <input name="name" type="text" value="{{ old('name') }}" autocomplete="name" class="mt-2 w-full rounded-lg border border-sky-200 px-3 py-3" required autofocus>
                @error('name')<span class="mt-1 block text-sm text-red-600">{{ $message }}</span>@enderror
            </label>
            <label>
                <span class="text-sm font-bold text-slate-700">Email</span>
                <input name="email" type="email" value="{{ old('email') }}" autocomplete="email" class="mt-2 w-full rounded-lg border border-sky-200 px-3 py-3" required>
                @error('email')<span class="mt-1 block text-sm text-red-600">{{ $message }}</span>@enderror
            </label>
            <label>
                <span class="text-sm font-bold text-slate-700">Password</span>
                <input name="password" type="password" autocomplete="new-password" class="mt-2 w-full rounded-lg border border-sky-200 px-3 py-3" required>
                @error('password')<span class="mt-1 block text-sm text-red-600">{{ $message }}</span>@enderror
            </label>
            <label>
                <span class="text-sm font-bold text-slate-700">Confirm Password</span>
                <input name="password_confirmation" type="password" autocomplete="new-password" class="mt-2 w-full rounded-lg border border-sky-200 px-3 py-3" required>
            </label>
            <button type="submit" class="rounded-lg bg-blue-950 px-5 py-3 font-bold text-white transition hover:bg-sky-700">Register</button>
        </form>
        <a href="{{ route('login') }}" class="mt-5 inline-block text-sm font-bold text-sky-700">Already have an account?</a>
    </div>
</section>
@endsection
