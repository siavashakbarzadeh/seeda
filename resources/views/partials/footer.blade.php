{{-- Footer --}}
<footer class="bg-neutral-900 text-neutral-300 pt-16 pb-8">
    <div class="max-w-[1200px] mx-auto px-4 md:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-12 mb-12">

            {{-- Brand + Newsletter --}}
            <div class="lg:col-span-2">
                <a href="{{ route('home') }}" class="flex items-center gap-2 text-xl font-bold text-white mb-4">
                    <img src="{{ asset('seeda-icon.svg') }}" alt="Seeda" class="w-8 h-8">
                    seeda
                </a>
                <p class="text-sm text-neutral-400 leading-relaxed mb-6">
                    Boutique software consulting focused on building solutions that grow with your business.
                </p>

                {{-- Newsletter Form --}}
                <div>
                    <h4 class="text-white text-sm font-semibold mb-3">📧 Subscribe to Our Newsletter</h4>
                    <form action="{{ route('newsletter.subscribe') }}" method="POST" class="flex gap-2">
                        @csrf
                        <input type="email" name="email" required placeholder="your@email.com"
                            class="flex-1 bg-neutral-800 border border-neutral-700 text-white text-sm rounded-lg px-4 py-2.5 placeholder-neutral-500 focus:border-primary focus:outline-none focus:ring-1 focus:ring-primary transition-all">
                        <button type="submit"
                            class="px-5 py-2.5 bg-primary text-white text-sm font-semibold rounded-lg hover:bg-primary-dark transition-all shrink-0">
                            Subscribe
                        </button>
                    </form>
                    @if(session('success'))
                        <p class="text-xs text-green-400 mt-2">{{ session('success') }}</p>
                    @endif
                    @error('email')
                        <p class="text-xs text-red-400 mt-2">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Quick Links --}}
            <div>
                <h4 class="text-white text-sm font-semibold mb-4 uppercase tracking-wider">Company</h4>
                <ul class="space-y-3">
                    <li><a href="{{ route('about') }}" class="text-sm hover:text-primary transition-colors">About Us</a>
                    </li>
                    <li><a href="{{ route('services') }}"
                            class="text-sm hover:text-primary transition-colors">Services</a></li>
                    <li><a href="{{ route('case-studies') }}" class="text-sm hover:text-primary transition-colors">Case
                            Studies</a></li>
                    <li><a href="{{ route('blog') }}" class="text-sm hover:text-primary transition-colors">Blog</a></li>
                    <li><a href="{{ route('faq') }}" class="text-sm hover:text-primary transition-colors">FAQ</a></li>
                </ul>
            </div>

            {{-- Services --}}
            <div>
                <h4 class="text-white text-sm font-semibold mb-4 uppercase tracking-wider">Services</h4>
                <ul class="space-y-3">
                    <li><a href="{{ route('services') }}" class="text-sm hover:text-primary transition-colors">Custom
                            Software</a></li>
                    <li><a href="{{ route('services') }}" class="text-sm hover:text-primary transition-colors">AI &
                            Machine Learning</a></li>
                    <li><a href="{{ route('services') }}" class="text-sm hover:text-primary transition-colors">Cloud &
                            DevOps</a></li>
                    <li><a href="{{ route('services') }}" class="text-sm hover:text-primary transition-colors">Mobile
                            Apps</a></li>
                </ul>
            </div>

            {{-- Contact --}}
            <div>
                <h4 class="text-white text-sm font-semibold mb-4 uppercase tracking-wider">Contact</h4>
                <ul class="space-y-3 text-sm">
                    <li class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-primary shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        hello@seeda.dev
                    </li>
                    <li class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-primary shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                        +39 02 1234 5678
                    </li>
                    <li class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-primary shrink-0" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Milan, Italy
                    </li>
                </ul>
            </div>
        </div>

        {{-- Bottom --}}
        <div class="border-t border-neutral-800 pt-8 flex flex-col md:flex-row items-center justify-between gap-4">
            <p class="text-xs text-neutral-500">&copy; {{ date('Y') }} Seeda. All rights reserved.</p>
            <div class="flex gap-4">
                <a href="#" class="text-neutral-500 hover:text-white transition-colors" aria-label="LinkedIn">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
                    </svg>
                </a>
                <a href="#" class="text-neutral-500 hover:text-white transition-colors" aria-label="GitHub">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M12 0C5.374 0 0 5.373 0 12c0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23A11.509 11.509 0 0112 5.803c1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576C20.566 21.797 24 17.3 24 12c0-6.627-5.373-12-12-12z" />
                    </svg>
                </a>
                <a href="#" class="text-neutral-500 hover:text-white transition-colors" aria-label="Twitter">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z" />
                    </svg>
                </a>
            </div>
        </div>
    </div>
</footer>