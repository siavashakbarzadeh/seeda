@extends('layouts.app')
@section('title', 'Portfolio — Seeda')
@section('meta_description', 'Explore our portfolio: Web Apps, Enterprise Solutions, Mobile, AI and more.')

@section('content')

    {{-- Page Header --}}
    <section class="py-16 md:py-24 bg-gradient-to-b from-primary-bg to-white">
        <div class="max-w-[1200px] mx-auto px-4 md:px-8 text-center fade-in">
            <span class="text-sm font-semibold text-primary uppercase tracking-wider mb-2 block">Our Work</span>
            <h1 class="text-4xl md:text-5xl font-extrabold mb-4">Portfolio</h1>
            <p class="text-lg text-neutral-600 max-w-xl mx-auto">Real projects, real results. Explore how we've helped
                companies solve complex challenges with technology.</p>
        </div>
    </section>

    {{-- Filter + Grid --}}
    <section class="py-16 md:py-24">
        <div class="max-w-[1200px] mx-auto px-4 md:px-8">

            {{-- Category Filters --}}
            <div class="flex flex-wrap gap-2 justify-center mb-12 fade-in">
                <a href="{{ route('case-studies') }}"
                    class="px-5 py-2 rounded-full text-sm font-medium transition-all duration-200
                          {{ !$active ? 'bg-primary text-white shadow-md' : 'bg-neutral-100 text-neutral-600 hover:bg-neutral-200' }}">
                    All
                </a>
                @foreach ($categories as $cat)
                    <a href="{{ route('case-studies', ['category' => $cat]) }}"
                        class="px-5 py-2 rounded-full text-sm font-medium transition-all duration-200
                                  {{ $active === $cat ? 'bg-primary text-white shadow-md' : 'bg-neutral-100 text-neutral-600 hover:bg-neutral-200' }}">
                        {{ $cat }}
                    </a>
                @endforeach
            </div>

            {{-- Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                @foreach ($studies as $i => $study)
                    <div class="zoom-in stagger-{{ ($i % 2) + 1 }} bg-white rounded-2xl border border-neutral-100 overflow-hidden hover:shadow-xl hover:-translate-y-2 transition-all duration-400 group">

                        {{-- Thumbnail --}}
                        @if($study->thumbnail)
                            <div class="w-full aspect-[16/9] overflow-hidden">
                                <img src="{{ asset('storage/' . $study->thumbnail) }}" alt="{{ $study->title }}"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            </div>
                        @else
                            <div class="h-3 w-full" style="background: {{ $study->color }};"></div>
                        @endif

                        <div class="p-8">
                            <div class="flex items-center gap-3 mb-4">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold text-white"
                                    style="background: {{ $study->color }};">{{ $study->category }}</span>
                                @if($study->client_name)
                                    <span class="text-xs text-neutral-400 font-medium">{{ $study->client_name }}</span>
                                @endif
                                @if($study->duration)
                                    <span class="text-xs text-neutral-300">· {{ $study->duration }}</span>
                                @endif
                            </div>

                            <h3 class="text-xl font-bold text-neutral-900 mb-3 group-hover:text-primary transition-colors">
                                {{ $study->title }}</h3>
                            <p class="text-neutral-600 text-sm leading-relaxed mb-4">{{ $study->excerpt }}</p>

                            {{-- Tags --}}
                            <div class="flex flex-wrap gap-2 mb-5">
                                @foreach ($study->tags ?? [] as $tag)
                                    <span class="px-2.5 py-1 bg-neutral-50 text-neutral-500 text-xs font-medium rounded-md border border-neutral-100">{{ $tag }}</span>
                                @endforeach
                            </div>

                            {{-- Results --}}
                            @if(!empty($study->results))
                                <div class="grid grid-cols-2 gap-3 mb-5">
                                    @foreach ($study->results ?? [] as $result)
                                        <div class="bg-neutral-50 rounded-lg px-3 py-2 border border-neutral-100">
                                            <p class="text-xs font-semibold text-neutral-800">✓ {{ $result }}</p>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            {{-- Testimonial --}}
                            @if($study->testimonial_text)
                                <div class="bg-primary-bg/50 rounded-xl p-4 border border-primary-light/20">
                                    <p class="text-xs text-neutral-600 italic mb-1">"{{ $study->testimonial_text }}"</p>
                                    @if($study->testimonial_author)
                                        <p class="text-xs font-semibold text-primary">— {{ $study->testimonial_author }}</p>
                                    @endif
                                </div>
                            @endif

                            {{-- Live URL --}}
                            @if($study->live_url)
                                <div class="mt-4 pt-4 border-t border-neutral-100">
                                    <a href="{{ $study->live_url }}" target="_blank"
                                       class="inline-flex items-center text-sm text-primary font-semibold hover:gap-2 transition-all gap-1">
                                        Visit Live Site
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                        </svg>
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            @if($studies->isEmpty())
                <div class="text-center py-16">
                    <p class="text-neutral-400 text-lg">No projects found in this category.</p>
                    <a href="{{ route('case-studies') }}" class="text-primary font-semibold mt-2 inline-block">View All →</a>
                </div>
            @endif
        </div>
    </section>

    @include('partials.cta')

@endsection