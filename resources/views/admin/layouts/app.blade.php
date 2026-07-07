@php
    $adminNavGroups = [
        [
            'key' => 'dashboard',
            'label' => 'Dashboard',
            'active' => request()->routeIs('admin.dashboard'),
            'children' => [
                ['label' => 'Dashboard Overview', 'route' => 'admin.dashboard'],
            ],
        ],
        [
            'key' => 'products',
            'label' => 'Products',
            'active' => request()->routeIs('admin.products.*') || request()->routeIs('admin.product-variants.*') || request()->routeIs('admin.categories.*') || request()->routeIs('admin.inventory.*'),
            'children' => [
                ['label' => 'All Products', 'route' => 'admin.products.index'],
                ['label' => 'Add New Product', 'route' => 'admin.products.create'],
                ['label' => 'Product Variants', 'route' => 'admin.product-variants.index'],
                ['label' => 'Product Categories', 'route' => 'admin.categories.index'],
                ['label' => 'Inventory / Stock', 'route' => 'admin.products.index', 'params' => ['stock' => 'low']],
            ],
        ],
        [
            'key' => 'orders',
            'label' => 'Orders',
            'active' => request()->routeIs('admin.orders.*'),
            'children' => [
                ['label' => 'All Orders', 'route' => 'admin.orders.index'],
                ['label' => 'Pending Orders', 'route' => 'admin.orders.index', 'params' => ['status' => 'pending']],
                ['label' => 'Processing Orders', 'route' => 'admin.orders.index', 'params' => ['status' => 'processing']],
                ['label' => 'Completed Orders', 'route' => 'admin.orders.index', 'params' => ['status' => 'completed']],
                ['label' => 'Cancelled Orders', 'route' => 'admin.orders.index', 'params' => ['status' => 'cancelled']],
            ],
        ],
        [
            'key' => 'customers',
            'label' => 'Customers',
            'active' => false,
            'children' => [
                ['label' => 'All Customers', 'route' => 'admin.settings.index'],
                ['label' => 'Customer Orders', 'route' => 'admin.orders.index'],
            ],
        ],
        [
            'key' => 'blogs',
            'label' => 'Blogs',
            'active' => request()->routeIs('admin.blogs.*'),
            'children' => [
                ['label' => 'All Blog Posts', 'route' => 'admin.blogs.index'],
                ['label' => 'Add New Blog', 'route' => 'admin.blogs.create'],
                ['label' => 'Blog Categories', 'route' => 'admin.blogs.index'],
            ],
        ],
        [
            'key' => 'gallery',
            'label' => 'Gallery / Portfolio',
            'active' => request()->routeIs('admin.gallery.*'),
            'children' => [
                ['label' => 'All Gallery Items', 'route' => 'admin.gallery.index'],
                ['label' => 'Add Gallery Item', 'route' => 'admin.gallery.create'],
            ],
        ],
        [
            'key' => 'testimonials',
            'label' => 'Testimonials',
            'active' => request()->routeIs('admin.testimonials.*'),
            'children' => [
                ['label' => 'All Testimonials', 'route' => 'admin.testimonials.index'],
                ['label' => 'Add Testimonial', 'route' => 'admin.testimonials.create'],
            ],
        ],
        [
            'key' => 'payments',
            'label' => 'Payments',
            'active' => request()->routeIs('admin.payments.*'),
            'children' => [
                ['label' => 'Payment Records', 'route' => 'admin.payments.index'],
                ['label' => 'Payment Methods', 'route' => 'admin.payments.integration'],
                ['label' => 'Payment Integration Settings', 'route' => 'admin.payments.integration'],
            ],
        ],
        [
            'key' => 'messages',
            'label' => 'Contact Messages',
            'active' => request()->routeIs('admin.messages.*'),
            'children' => [
                ['label' => 'All Messages', 'route' => 'admin.messages.index'],
                ['label' => 'Unread Messages', 'route' => 'admin.messages.index', 'params' => ['status' => 'unread']],
            ],
        ],
        [
            'key' => 'content',
            'label' => 'Website Content',
            'active' => false,
            'children' => [
                ['label' => 'Home Page Sections', 'route' => 'admin.settings.index'],
                ['label' => 'About Page Content', 'route' => 'admin.settings.index'],
                ['label' => 'Contact Information', 'route' => 'admin.settings.index'],
                ['label' => 'Policies', 'route' => 'admin.settings.index'],
            ],
        ],
        [
            'key' => 'settings',
            'label' => 'Settings',
            'active' => request()->routeIs('admin.settings.*'),
            'children' => [
                ['label' => 'General Settings', 'route' => 'admin.settings.index'],
                ['label' => 'Website Settings', 'route' => 'admin.settings.index'],
                ['label' => 'Store Settings', 'route' => 'admin.settings.index'],
                ['label' => 'Shipping Settings', 'route' => 'admin.settings.index'],
                ['label' => 'Tax Settings', 'route' => 'admin.settings.index'],
                ['label' => 'Payment Integration', 'route' => 'admin.payments.integration'],
            ],
        ],
    ];
@endphp
<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $metaTitle ?? 'Admin Dashboard | M&M Custom Tackle' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="admin-shell min-h-screen bg-slate-950 text-slate-100">
    <div class="flex min-h-screen">
        <aside id="admin-sidebar" class="admin-sidebar fixed inset-y-0 left-0 z-50 hidden w-72 overflow-y-auto border-r border-slate-800 bg-slate-950 p-5 shadow-2xl shadow-sky-950/40 lg:block">
            <div class="flex items-center justify-between gap-3">
                <a href="{{ route('admin.dashboard') }}" class="font-black text-white">M&M Admin</a>
                <button type="button" class="admin-sidebar-close rounded-lg border border-slate-700 px-3 py-2 text-sm lg:hidden">Close</button>
            </div>
            <nav class="mt-8 grid gap-2 text-sm" data-admin-sidebar data-active-dropdown="{{ collect($adminNavGroups)->firstWhere('active', true)['key'] ?? '' }}">
                @foreach ($adminNavGroups as $group)
                    <div class="admin-nav-group" data-dropdown-group="{{ $group['key'] }}">
                        <button type="button" data-dropdown-toggle="{{ $group['key'] }}" aria-expanded="{{ $group['active'] ? 'true' : 'false' }}" class="admin-nav-parent flex w-full items-center justify-between rounded-lg border border-transparent px-3 py-2.5 text-left font-bold text-slate-200 transition hover:border-sky-500/30 hover:bg-sky-500/10 hover:text-sky-100 {{ $group['active'] ? 'border-sky-500/40 bg-sky-500/15 text-sky-100' : '' }}">
                            <span>{{ $group['label'] }}</span>
                            <svg class="admin-nav-chevron h-4 w-4 transition-transform duration-200 {{ $group['active'] ? 'rotate-180' : '' }}" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 11.168l3.71-3.938a.75.75 0 1 1 1.08 1.04l-4.25 4.5a.75.75 0 0 1-1.08 0l-4.25-4.5a.75.75 0 0 1 .02-1.06Z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        <div data-dropdown-panel="{{ $group['key'] }}" class="admin-nav-panel grid overflow-hidden transition-[grid-template-rows] duration-300 ease-out {{ $group['active'] ? 'grid-rows-[1fr]' : 'grid-rows-[0fr]' }}">
                            <div class="min-h-0">
                                <div class="mt-1 grid gap-1 border-l border-slate-800 pl-3">
                                    @foreach ($group['children'] as $item)
                                        @php
                                            $childActive = request()->routeIs($item['route']) && collect($item['params'] ?? [])->every(fn ($value, $key) => request((string) $key) === $value);
                                            if (empty($item['params']) && request()->routeIs($item['route']) && ! request()->query()) {
                                                $childActive = true;
                                            }
                                        @endphp
                                        <a href="{{ route($item['route'], $item['params'] ?? []) }}" class="rounded-lg px-3 py-2 text-xs font-semibold text-slate-400 transition hover:bg-sky-500/10 hover:text-sky-200 {{ $childActive ? 'bg-sky-500/20 text-sky-100 ring-1 ring-sky-500/30' : '' }}">{{ $item['label'] }}</a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                <a href="{{ route('home') }}" class="mt-4 rounded-lg border border-slate-700 px-3 py-2 text-center font-bold text-sky-200">Back to Website</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="mt-2 w-full rounded-lg bg-red-500/15 px-3 py-2 text-left font-bold text-red-200 transition hover:bg-red-500/25">Logout</button>
                </form>
            </nav>
        </aside>

        <div class="min-w-0 flex-1 lg:pl-72">
            <header class="admin-topbar sticky top-0 z-40 border-b border-slate-800 bg-slate-950/90 px-4 py-4 backdrop-blur sm:px-6 lg:px-8">
                <div class="flex items-center justify-between gap-4">
                    <button type="button" class="admin-sidebar-toggle rounded-lg border border-slate-700 px-3 py-2 text-sm font-bold text-slate-100 lg:hidden">Menu</button>
                    <div>
                        <p class="text-xs font-bold uppercase tracking-wide text-sky-300">Ecommerce Admin</p>
                        <h1 class="text-xl font-black text-white">@yield('page-title', 'Dashboard')</h1>
                    </div>
                    <div class="flex items-center gap-3">
                        <button type="button" data-theme-toggle data-theme-scope="admin" class="rounded-lg border border-slate-700 px-3 py-2 text-sm font-bold">Mode: <span data-theme-label="admin">Dark</span></button>
                        <div class="hidden text-right text-sm sm:block">
                            <p class="font-bold text-white">{{ auth()->user()->name }}</p>
                            <p class="text-slate-400">{{ auth()->user()->email }}</p>
                        </div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="rounded-lg bg-sky-500 px-3 py-2 text-sm font-bold text-slate-950">Logout</button>
                        </form>
                    </div>
                </div>
            </header>

            <main class="px-4 py-8 sm:px-6 lg:px-8">
                @if (session('success'))
                    <div class="mb-6 rounded-lg border border-emerald-400/30 bg-emerald-500/10 px-4 py-3 text-sm font-bold text-emerald-200">{{ session('success') }}</div>
                @endif
                @if (session('error'))
                    <div class="mb-6 rounded-lg border border-red-400/30 bg-red-500/10 px-4 py-3 text-sm font-bold text-red-200">{{ session('error') }}</div>
                @endif
                @yield('content')
            </main>

            <footer class="border-t border-slate-800 px-4 py-6 text-center text-sm text-slate-500 sm:px-6 lg:px-8">
                M&M Custom Tackle admin portal
            </footer>
        </div>
    </div>
</body>
</html>
