@extends('layouts.app')
@section('title', 'Seeda — Software Consulting')

@section('content')

    {{-- Hero --}}
    <section
        class="relative min-h-[calc(100vh-72px)] flex items-center overflow-hidden bg-gradient-to-br from-white to-primary-bg">
        <div
            class="max-w-[1200px] mx-auto px-4 md:px-8 relative z-10 grid grid-cols-1 lg:grid-cols-2 gap-16 items-center py-12">

            {{-- Text --}}
            <div class="max-w-xl fade-in">
                <div
                    class="inline-flex items-center gap-2 bg-white border border-neutral-200 rounded-full px-4 py-1.5 text-sm font-medium text-neutral-700 shadow-sm mb-8">
                    <span class="w-2 h-2 bg-primary rounded-full animate-pulse-dot"></span>
                    Software Consulting That Grows With You
                </div>

                <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold leading-[1.08] tracking-tight mb-6">
                    We Plant the Seeds of
                    <span class="bg-gradient-to-r from-primary to-primary-light bg-clip-text text-transparent">Digital
                        Innovation</span>
                </h1>

                <p class="text-lg text-neutral-600 leading-relaxed mb-8 max-w-md">
                    Seeda is a boutique software consulting company that helps ambitious businesses design, build, and scale
                    modern technology solutions — from idea to impact.
                </p>

                <div class="flex flex-wrap gap-4 mb-12">
                    <a href="{{ route('contact') }}"
                        class="inline-flex items-center px-7 py-3.5 bg-primary text-white font-semibold rounded-xl hover:bg-primary-dark transition-all shadow-md hover:shadow-lg hover:-translate-y-0.5">
                        Start a Project
                    </a>
                    <a href="{{ route('case-studies') }}"
                        class="inline-flex items-center px-7 py-3.5 border-2 border-neutral-200 text-neutral-700 font-semibold rounded-xl hover:border-primary hover:text-primary transition-all">
                        View Our Work
                    </a>
                </div>

                {{-- Stats --}}
                <div class="flex gap-12 pt-8 border-t border-neutral-200">
                    @foreach ($stats as $stat)
                        <div>
                            <h3 class="text-3xl font-bold text-primary">{{ $stat['value'] }}</h3>
                            <p class="text-sm text-neutral-400 mt-1">{{ $stat['label'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Visual --}}
            <div class="relative hidden lg:flex items-center justify-center">
                <div
                    class="w-full max-w-[500px] aspect-square bg-gradient-to-br from-primary to-primary-light rounded-full opacity-[0.08]">
                </div>
                <div class="absolute inset-[40px] border-2 border-dashed border-primary/30 rounded-full animate-spin-slow">
                </div>

                {{-- Float Cards --}}
                <div class="absolute top-[15%] right-0 bg-white rounded-2xl p-4 shadow-lg flex items-center gap-3 z-10 animate-float"
                    style="animation-delay: 0s;">
                    <div class="w-11 h-11 bg-green-50 text-primary rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-semibold">Clean Code</h4>
                        <p class="text-xs text-neutral-400">Maintainable & scalable</p>
                    </div>
                </div>

                <div class="absolute bottom-[25%] -left-[10%] bg-white rounded-2xl p-4 shadow-lg flex items-center gap-3 z-10 animate-float"
                    style="animation-delay: 2s;">
                    <div class="w-11 h-11 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-semibold">AI-Powered</h4>
                        <p class="text-xs text-neutral-400">Smart data solutions</p>
                    </div>
                </div>

                <div class="absolute bottom-[8%] right-[5%] bg-white rounded-2xl p-4 shadow-lg flex items-center gap-3 z-10 animate-float"
                    style="animation-delay: 4s;">
                    <div class="w-11 h-11 bg-amber-50 text-amber-600 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-semibold">Fast Delivery</h4>
                        <p class="text-xs text-neutral-400">Agile methodology</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Services Preview --}}
    <section class="py-16 md:py-24">
        <div class="max-w-[1200px] mx-auto px-4 md:px-8">
            <div class="text-center mb-12 fade-in">
                <span class="text-sm font-semibold text-primary uppercase tracking-wider">What We Do</span>
                <h2 class="text-3xl md:text-4xl font-bold mt-3 mb-4">Our Core Services</h2>
                <div class="w-12 h-1 bg-primary rounded-full mx-auto mb-4"></div>
                <p class="text-neutral-600 max-w-xl mx-auto">We combine deep technical expertise with strategic thinking to
                    deliver solutions that make an impact.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach ($services as $i => $service)
                    <div
                        class="zoom-in stagger-{{ $i + 1 }} bg-white rounded-2xl border border-neutral-100 p-8 hover:shadow-xl hover:-translate-y-2 hover:border-primary-light transition-all duration-400 group">
                        <div
                            class="w-14 h-14 bg-primary-bg text-primary rounded-xl flex items-center justify-center mb-6 group-hover:rotate-6 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-neutral-900 mb-3">{{ $service->title }}</h3>
                        <p class="text-neutral-600 text-sm leading-relaxed">{{ $service->description }}</p>
                    </div>
                @endforeach
            </div>

            <div class="text-center mt-12 fade-in">
                <a href="{{ route('services') }}"
                    class="inline-flex items-center px-6 py-3 border-2 border-neutral-200 text-neutral-700 font-semibold rounded-xl hover:border-primary hover:text-primary transition-all gap-2">
                    View All Services
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
        </div>
    </section>

    {{-- Portfolio Showcase --}}
    @php
        $portfolioStudies = \App\Models\CaseStudy::active()->featured()->take(4)->get();
    @endphp
    @if ($portfolioStudies->isNotEmpty())
        <section class="py-16 md:py-24 bg-neutral-50">
            <div class="max-w-[1200px] mx-auto px-4 md:px-8">
                <div class="text-center mb-12 fade-in">
                    <span class="text-sm font-semibold text-primary uppercase tracking-wider">Portfolio</span>
                    <h2 class="text-3xl md:text-4xl font-bold mt-3 mb-4">Our Recent Work</h2>
                    <div class="w-12 h-1 bg-primary rounded-full mx-auto mb-4"></div>
                    <p class="text-neutral-600 max-w-xl mx-auto">Real projects we've built for real clients — from restaurant platforms to enterprise management suites.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    @foreach($portfolioStudies as $i => $study)
                        <div class="zoom-in stagger-{{ ($i % 2) + 1 }} bg-white rounded-2xl border border-neutral-100 overflow-hidden hover:shadow-xl hover:-translate-y-2 transition-all duration-400 group">
                            {{-- Thumbnail / Color Header --}}
                            @if($study->thumbnail)
                                <div class="w-full aspect-[16/9] overflow-hidden">
                                    <img src="{{ asset('storage/' . $study->thumbnail) }}" alt="{{ $study->title }}"
                                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                </div>
                            @else
                                <div class="w-full aspect-[16/9] flex items-center justify-center" style="background: {{ $study->color }}15;">
                                    <span class="text-5xl font-bold" style="color: {{ $study->color }};">{{ substr($study->title, 0, 2) }}</span>
                                </div>
                            @endif

                            <div class="p-6">
                                <div class="flex items-center gap-3 mb-3">
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold text-white" style="background: {{ $study->color }};">
                                        {{ $study->category }}
                                    </span>
                                    @if($study->client_name)
                                        <span class="text-xs text-neutral-400">{{ $study->client_name }}</span>
                                    @endif
                                </div>

                                <h3 class="text-xl font-bold text-neutral-900 mb-2 group-hover:text-primary transition-colors">{{ $study->title }}</h3>
                                <p class="text-neutral-600 text-sm leading-relaxed mb-4">{{ $study->excerpt }}</p>

                                {{-- Tags --}}
                                <div class="flex flex-wrap gap-1.5 mb-4">
                                    @foreach (array_slice($study->tags ?? [], 0, 4) as $tag)
                                        <span class="px-2 py-0.5 bg-neutral-50 text-neutral-500 text-xs font-medium rounded-md border border-neutral-100">{{ $tag }}</span>
                                    @endforeach
                                </div>

                                {{-- Results --}}
                                <div class="grid grid-cols-2 gap-2">
                                    @foreach (array_slice($study->results ?? [], 0, 2) as $result)
                                        <div class="bg-neutral-50 rounded-lg px-3 py-2 border border-neutral-100">
                                            <p class="text-xs font-semibold text-neutral-800">✓ {{ $result }}</p>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="text-center mt-12 fade-in">
                    <a href="{{ route('case-studies') }}"
                        class="inline-flex items-center px-7 py-3.5 bg-primary text-white font-semibold rounded-xl hover:bg-primary-dark transition-all shadow-md hover:shadow-lg hover:-translate-y-0.5 gap-2">
                        View All Projects
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                </div>
            </div>
        </section>
    @endif

    {{-- Testimonials --}}
    @if(isset($testimonials) && $testimonials->isNotEmpty())
        <section class="py-16 md:py-24">
            <div class="max-w-[1200px] mx-auto px-4 md:px-8">
                <div class="text-center mb-12 fade-in">
                    <span class="text-sm font-semibold text-primary uppercase tracking-wider">Testimonials</span>
                    <h2 class="text-3xl md:text-4xl font-bold mt-3 mb-4">What Our Clients Say</h2>
                    <div class="w-12 h-1 bg-primary rounded-full mx-auto"></div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @foreach($testimonials as $i => $testimonial)
                        <div class="zoom-in stagger-{{ $i + 1 }} bg-white rounded-2xl border border-neutral-100 p-8 hover:shadow-xl transition-all duration-400">
                            {{-- Stars --}}
                            <div class="flex gap-1 mb-4">
                                @for($s = 1; $s <= 5; $s++)
                                    <svg class="w-5 h-5 {{ $s <= ($testimonial->rating ?? 5) ? 'text-amber-400' : 'text-neutral-200' }}" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @endfor
                            </div>

                            <p class="text-neutral-600 text-sm leading-relaxed mb-6 italic">
                                "{{ $testimonial->content }}"
                            </p>

                            <div class="flex items-center gap-3">
                                @if($testimonial->avatar)
                                    <img src="{{ asset('storage/' . $testimonial->avatar) }}" alt="{{ $testimonial->client_name }}"
                                         class="w-10 h-10 rounded-full object-cover">
                                @else
                                    <div class="w-10 h-10 rounded-full bg-primary-bg text-primary font-bold text-sm flex items-center justify-center">
                                        {{ substr($testimonial->client_name, 0, 1) }}
                                    </div>
                                @endif
                                <div>
                                    <p class="text-sm font-semibold text-neutral-900">{{ $testimonial->client_name }}</p>
                                    <p class="text-xs text-neutral-400">{{ $testimonial->position }}{{ $testimonial->company ? ', ' . $testimonial->company : '' }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- CTA --}}
    <section class="py-20 bg-gradient-to-br from-primary to-primary-dark relative overflow-hidden">
        <div class="absolute top-[-50px] right-[-50px] w-[200px] h-[200px] bg-white/10 rounded-full"></div>
        <div class="absolute bottom-[-80px] left-[-30px] w-[300px] h-[300px] bg-white/5 rounded-full"></div>
        <div class="max-w-[1200px] mx-auto px-4 md:px-8 text-center relative z-10 fade-in">
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Ready to Grow Your Business?</h2>
            <p class="text-white/80 max-w-lg mx-auto mb-8 text-lg">Let's talk about your next project. We'll help you find
                the right technology solution to meet your goals.</p>
            <a href="{{ route('contact') }}"
                class="inline-flex items-center px-8 py-4 bg-white text-primary font-bold rounded-xl hover:shadow-xl hover:-translate-y-0.5 transition-all">
                Start a Conversation
            </a>
        </div>
    </section>

@endsection