{{-- Sticky Navbar with Glassmorphism --}}
<header class="sticky top-0 z-50 bg-white/80 backdrop-blur-lg border-b border-neutral-100 transition-all duration-300">
    <div class="max-w-[1200px] mx-auto px-4 md:px-8 flex items-center justify-between h-[72px]">

        {{-- Logo --}}
        <a href="{{ route('home') }}"
            class="flex items-center gap-2 text-xl font-bold text-neutral-900 hover:text-primary transition-colors">
            <img src="{{ asset('seeda-icon.svg') }}" alt="Seeda" class="w-8 h-8">
            seeda
        </a>

        {{-- Desktop Nav --}}
        <nav class="hidden md:flex items-center gap-8">
            @php
                $links = [
                    ['route' => 'home', 'label' => 'Home'],
                    ['route' => 'services', 'label' => 'Services'],
                    ['route' => 'case-studies', 'label' => 'Case Studies'],
                    ['route' => 'blog', 'label' => 'Blog'],
                    ['route' => 'about', 'label' => 'About'],
                ];
            @endphp

            @foreach ($links as $link)
                <a href="{{ route($link['route']) }}"
                    class="relative text-sm font-medium transition-colors duration-200
                                      {{ request()->routeIs($link['route']) ? 'text-primary' : 'text-neutral-600 hover:text-neutral-900' }}">
                    {{ $link['label'] }}
                    @if(request()->routeIs($link['route']))
                        <span class="absolute -bottom-1 left-0 right-0 h-0.5 bg-primary rounded-full"></span>
                    @endif
                </a>
            @endforeach

            <a href="{{ route('contact') }}"
                class="inline-flex items-center px-5 py-2.5 bg-primary text-white text-sm font-semibold rounded-lg hover:bg-primary-dark transition-all duration-200 shadow-sm hover:shadow-md hover:-translate-y-0.5">
                Get in Touch
            </a>

            @auth
                <a href="{{ auth()->user()->isAdmin() ? '/admin' : '/portal' }}"
                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-neutral-600 hover:text-primary border border-neutral-200 rounded-lg hover:border-primary/30 transition-all duration-200">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                    </svg>
                    Dashboard
                </a>
            @else
                <a href="{{ route('login') }}"
                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-neutral-600 hover:text-primary border border-neutral-200 rounded-lg hover:border-primary/30 transition-all duration-200">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                    </svg>
                    Login
                </a>
            @endauth
        </nav>

        {{-- Mobile Toggle --}}
        <button id="mobile-menu-toggle" class="md:hidden p-2 text-neutral-700" aria-label="Menu">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
    </div>

    {{-- Mobile Overlay --}}
    <div id="mobile-overlay" class="fixed inset-0 bg-black/40 z-40 hidden md:hidden"></div>

    {{-- Mobile Drawer --}}
    <div id="mobile-drawer"
        class="fixed top-0 right-0 w-72 h-full bg-white z-50 shadow-2xl transform translate-x-full transition-transform duration-300 md:hidden">
        <div class="p-6 flex flex-col gap-6">
            <div class="flex justify-between items-center mb-4">
                <span class="text-lg font-bold text-neutral-900">Menu</span>
                <button onclick="document.getElementById('mobile-overlay').click()"
                    class="p-2 text-neutral-400 hover:text-neutral-700">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <a href="{{ route('home') }}"
                class="text-base font-medium text-neutral-700 hover:text-primary py-2">Home</a>
            <a href="{{ route('services') }}"
                class="text-base font-medium text-neutral-700 hover:text-primary py-2">Services</a>
            <a href="{{ route('case-studies') }}"
                class="text-base font-medium text-neutral-700 hover:text-primary py-2">Case Studies</a>
            <a href="{{ route('about') }}"
                class="text-base font-medium text-neutral-700 hover:text-primary py-2">About</a>
            <a href="{{ route('contact') }}"
                class="mt-4 inline-flex justify-center px-5 py-3 bg-primary text-white font-semibold rounded-lg">Get in
                Touch</a>

            @auth
                <a href="{{ auth()->user()->isAdmin() ? '/admin' : '/portal' }}"
                    class="inline-flex justify-center px-5 py-3 text-primary border border-primary/30 font-semibold rounded-lg">Dashboard</a>
            @else
                <a href="{{ route('login') }}"
                    class="inline-flex justify-center px-5 py-3 text-primary border border-primary/30 font-semibold rounded-lg">Login</a>
            @endauth
        </div>
    </div>
</header>