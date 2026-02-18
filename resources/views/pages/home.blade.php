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

    {{-- Featured Case Study --}}
    @if ($featuredStudy)
        <section class="py-16 md:py-24 bg-neutral-50">
            <div class="max-w-[1200px] mx-auto px-4 md:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                    <div class="fade-in-left">
                        <div class="w-full aspect-[4/3] rounded-2xl overflow-hidden"
                            style="background: {{ $featuredStudy->color }}20;">
                            <div class="w-full h-full flex items-center justify-center text-6xl font-bold"
                                style="color: {{ $featuredStudy->color }};">
                                {{ substr($featuredStudy->title, 0, 2) }}
                            </div>
                        </div>
                    </div>
                    <div class="fade-in-right">
                        <span class="text-sm font-semibold text-primary uppercase tracking-wider">Featured Project</span>
                        <h2 class="text-3xl font-bold mt-3 mb-4">{{ $featuredStudy->title }}</h2>
                        <p class="text-neutral-600 mb-6 leading-relaxed">{{ $featuredStudy->excerpt }}</p>
                        <div class="flex flex-wrap gap-2 mb-6">
                            @foreach ($featuredStudy->tags ?? [] as $tag)
                                <span
                                    class="px-3 py-1 bg-neutral-100 text-neutral-600 text-xs font-medium rounded-full">{{ $tag }}</span>
                            @endforeach
                        </div>
                        <div class="grid grid-cols-2 gap-4 mb-8">
                            @foreach (array_slice($featuredStudy->results ?? [], 0, 4) as $result)
                                <div class="bg-white rounded-xl p-4 border border-neutral-100">
                                    <p class="text-sm font-semibold text-neutral-900">{{ $result }}</p>
                                </div>
                            @endforeach
                        </div>
                        <a href="{{ route('case-studies') }}"
                            class="inline-flex items-center text-primary font-semibold hover:gap-3 transition-all gap-2">
                            View All Projects
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
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