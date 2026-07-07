@php
    $metaTitle = $metaTitle ?? 'M&M Custom Tackle | Custom Fishing Tackle in Sarasota, Florida';
    $metaDescription = $metaDescription ?? 'Handcrafted fishing tackle, custom jigs, and saltwater fishing products from Sarasota, Florida.';
    $logoPath = asset('assets/logo/logo.jpg');
    $cartCount = collect(session('cart', []))->sum();
    $navLinks = [
        ['label' => 'Home', 'route' => 'home'],
        ['label' => 'About', 'route' => 'about'],
        ['label' => 'Shop', 'route' => 'products.index'],
        ['label' => 'Gallery', 'route' => 'gallery'],
        ['label' => 'Pricing', 'route' => 'pricing'],
        ['label' => 'Testimonials', 'route' => 'testimonials'],
        ['label' => 'Blog', 'route' => 'blog.index'],
        ['label' => 'Contact', 'route' => 'contact'],
    ];
@endphp
<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $metaTitle }}</title>
    <meta name="description" content="{{ $metaDescription }}">
    <link rel="canonical" href="{{ url()->current() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-sky-50 text-slate-900 antialiased">
    <header class="sticky top-0 z-50 border-b border-sky-100 bg-white/95 shadow-sm backdrop-blur">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-3 sm:px-6 lg:px-8">
            <a href="{{ route('home') }}" class="flex items-center gap-3" aria-label="M&M Custom Tackle home">
                <img src="{{ $logoPath }}" alt="M&M Custom Tackle logo" class="h-12 w-12 rounded-full object-cover ring-2 ring-sky-100">
                <span class="hidden text-lg font-bold text-blue-950 sm:block">M&M Custom Tackle</span>
            </a>

            <nav class="hidden items-center gap-5 text-sm font-semibold text-slate-700 lg:flex" aria-label="Primary navigation">
                @foreach ($navLinks as $link)
                    <a href="{{ route($link['route']) }}" class="relative transition hover:text-sky-600 after:absolute after:-bottom-1 after:left-0 after:h-0.5 after:bg-sky-500 after:transition-all {{ request()->routeIs($link['route']) ? 'text-sky-700 after:w-full' : 'after:w-0 hover:after:w-full' }}">{{ $link['label'] }}</a>
                @endforeach
            </nav>

            <div class="hidden items-center gap-3 lg:flex">
                <a href="{{ route('cart.index') }}" class="relative rounded-full border border-sky-200 p-3 text-blue-950 transition hover:bg-sky-50" aria-label="Cart">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M6 6h15l-2 9H8L6 6Z"/><path d="M6 6 5 3H2"/><circle cx="9" cy="20" r="1"/><circle cx="18" cy="20" r="1"/></svg>
                    <span class="absolute -right-1 -top-1 rounded-full bg-sky-500 px-1.5 py-0.5 text-xs font-bold text-white">{{ $cartCount }}</span>
                </a>
                <button type="button" data-theme-toggle data-theme-scope="public" class="rounded-full border border-sky-200 px-3 py-2 text-sm font-bold text-blue-950 transition hover:bg-sky-50">Theme</button>
                @guest
                    <a href="{{ route('login') }}" class="rounded-full bg-blue-950 px-4 py-2 text-sm font-bold text-white transition hover:bg-sky-700">Login</a>
                    <a href="{{ route('register') }}" class="rounded-full border border-sky-200 px-4 py-2 text-sm font-bold text-blue-950 transition hover:bg-sky-50">Register</a>
                @else
                    @if (auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="rounded-full bg-blue-950 px-4 py-2 text-sm font-bold text-white transition hover:bg-sky-700">Admin Dashboard</a>
                    @else
                        <a href="{{ route('customer.account') }}" class="rounded-full bg-blue-950 px-4 py-2 text-sm font-bold text-white transition hover:bg-sky-700">My Account</a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="rounded-full border border-sky-200 px-4 py-2 text-sm font-bold text-blue-950 transition hover:bg-sky-50">Logout</button>
                    </form>
                @endguest
            </div>

            <button class="mobile-menu-toggle rounded-full border border-sky-200 p-3 text-blue-950 lg:hidden" aria-controls="mobile-menu" aria-expanded="false">
                <span class="sr-only">Open menu</span>
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M4 7h16M4 12h16M4 17h16"/></svg>
            </button>
        </div>
        <div id="mobile-menu" class="hidden border-t border-sky-100 bg-white px-4 py-4 lg:hidden">
            <nav class="grid gap-3 text-sm font-semibold text-slate-700" aria-label="Mobile navigation">
                @foreach ($navLinks as $link)
                    <a href="{{ route($link['route']) }}" class="rounded-lg px-3 py-2 transition hover:bg-sky-50 hover:text-sky-700 {{ request()->routeIs($link['route']) ? 'bg-sky-50 text-sky-700' : '' }}">{{ $link['label'] }}</a>
                @endforeach
                <div class="grid gap-3 pt-2 sm:grid-cols-2">
                    <a href="{{ route('cart.index') }}" class="rounded-lg border border-sky-200 px-3 py-2 text-center">Cart ({{ $cartCount }})</a>
                    @guest
                        <a href="{{ route('login') }}" class="rounded-lg bg-blue-950 px-3 py-2 text-center text-white">Login</a>
                        <a href="{{ route('register') }}" class="rounded-lg border border-sky-200 px-3 py-2 text-center">Register</a>
                    @else
                        <button type="button" data-theme-toggle data-theme-scope="public" class="rounded-lg border border-sky-200 px-3 py-2 text-center">Theme</button>
                        @if (auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="rounded-lg bg-blue-950 px-3 py-2 text-center text-white">Admin Dashboard</a>
                        @else
                            <a href="{{ route('customer.account') }}" class="rounded-lg bg-blue-950 px-3 py-2 text-center text-white">My Account</a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full rounded-lg border border-sky-200 px-3 py-2 text-center">Logout</button>
                        </form>
                    @endguest
                </div>
            </nav>
        </div>
    </header>

    @if (session('success'))
        <div class="mx-auto mt-4 max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-800">{{ session('success') }}</div>
        </div>
    @endif
    @if (session('error'))
        <div class="mx-auto mt-4 max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm font-semibold text-red-800">{{ session('error') }}</div>
        </div>
    @endif

    <main>
        @yield('content')
    </main>

    <footer class="mt-20 bg-blue-950 text-white">
        <div class="mx-auto grid max-w-7xl gap-10 px-4 py-12 sm:px-6 md:grid-cols-2 lg:grid-cols-4 lg:px-8">
            <div data-aos="fade-up">
                <img src="{{ $logoPath }}" alt="M&M Custom Tackle logo" class="mb-4 h-16 w-16 rounded-full object-cover ring-2 ring-sky-300">
                <p class="text-sm leading-6 text-sky-100">Handcrafted fishing tackle from Sarasota, Florida, built for anglers who care about performance, durability, and confidence on the water.</p>
            </div>
            <div data-aos="fade-up" data-aos-delay="100">
                <h2 class="text-sm font-bold uppercase tracking-wide text-sky-200">Quick Links</h2>
                <div class="mt-4 grid gap-2 text-sm text-sky-50">
                    @foreach (['About' => 'about', 'Shop' => 'products.index', 'Gallery' => 'gallery', 'Contact' => 'contact'] as $label => $route)
                        <a href="{{ route($route) }}" class="w-fit transition hover:translate-x-1 hover:text-sky-300 hover:underline">{{ $label }}</a>
                    @endforeach
                </div>
            </div>
            <div data-aos="fade-up" data-aos-delay="200">
                <h2 class="text-sm font-bold uppercase tracking-wide text-sky-200">Categories</h2>
                <div class="mt-4 grid gap-2 text-sm text-sky-50">
                    <a href="{{ route('products.index', ['category' => 'custom-jigs']) }}" class="w-fit transition hover:translate-x-1 hover:text-sky-300 hover:underline">Custom Jigs</a>
                    <a href="{{ route('products.index', ['category' => 'jig-heads']) }}" class="w-fit transition hover:translate-x-1 hover:text-sky-300 hover:underline">Jig Heads</a>
                    <a href="{{ route('products.index', ['category' => 'bucktail-jigs']) }}" class="w-fit transition hover:translate-x-1 hover:text-sky-300 hover:underline">Bucktail Jigs</a>
                    <a href="{{ route('products.index', ['category' => 'fishing-accessories']) }}" class="w-fit transition hover:translate-x-1 hover:text-sky-300 hover:underline">Accessories</a>
                </div>
            </div>
            <div data-aos="fade-up" data-aos-delay="300">
                <h2 class="text-sm font-bold uppercase tracking-wide text-sky-200">Contact</h2>
                <div class="mt-4 space-y-2 text-sm text-sky-50">
                    <p>M&M Custom Tackle</p>
                    <p>Sarasota, Florida</p>
                    <p><a href="mailto:Mandmcustomtackle@gmail.com" class="hover:text-sky-300">Mandmcustomtackle@gmail.com</a></p>
                    <p><a href="tel:+19415441066" class="hover:text-sky-300">(941) 544-1066</a></p>
                </div>
                <form class="mt-5 flex gap-2">
                    <input type="email" placeholder="Email" aria-label="Newsletter email" class="min-w-0 flex-1 rounded-lg border-0 px-3 py-2 text-sm text-slate-900">
                    <button type="button" class="rounded-lg bg-sky-400 px-4 py-2 text-sm font-bold text-blue-950 transition hover:bg-sky-300">Join</button>
                </form>
                <p class="mt-4 text-xs text-sky-200">Social: Facebook / Instagram / YouTube</p>
            </div>
        </div>
        <div class="border-t border-white/10 px-4 py-5 text-center text-sm text-sky-100">&copy; 2026 M&M Custom Tackle. All Rights Reserved.</div>
    </footer>
</body>
</html>
