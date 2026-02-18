@extends('layouts.app')
@section('title', 'Services — Seeda')
@section('meta_description', 'End-to-end technology services: custom development, AI, cloud, product design, and mobile.')

@section('content')

    {{-- Page Header --}}
    <section class="py-16 md:py-24 bg-gradient-to-b from-primary-bg to-white">
        <div class="max-w-[1200px] mx-auto px-4 md:px-8 text-center fade-in">
            <h1 class="text-4xl md:text-5xl font-extrabold mb-4">Our Services</h1>
            <p class="text-lg text-neutral-600 max-w-xl mx-auto">From strategy to execution, we offer end-to-end technology
                services designed to accelerate your growth.</p>
        </div>
    </section>

    {{-- Services Grid --}}
    <section class="py-16 md:py-24">
        <div class="max-w-[1200px] mx-auto px-4 md:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                @foreach ($services as $i => $service)
                    <div
                        class="zoom-in stagger-{{ ($i % 2) + 1 }} bg-white rounded-2xl border border-neutral-100 p-8 md:p-10 hover:shadow-xl hover:-translate-y-2 hover:border-primary-light transition-all duration-400 group">
                        <div class="flex items-start gap-5">
                            <div
                                class="w-14 h-14 bg-primary-bg text-primary rounded-xl flex items-center justify-center shrink-0 group-hover:rotate-6 transition-transform">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-neutral-900 mb-2">{{ $service->title }}</h3>
                                <p class="text-neutral-600 text-sm leading-relaxed mb-4">{{ $service->description }}</p>
                            </div>
                        </div>

                        @if ($service->features)
                            <ul class="mt-6 space-y-3 border-t border-neutral-100 pt-6">
                                @foreach ($service->features as $feature)
                                    <li class="flex items-center gap-3 text-sm text-neutral-700">
                                        <svg class="w-4 h-4 text-primary shrink-0" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                d="M5 13l4 4L19 7" />
                                        </svg>
                                        {{ $feature }}
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- CTA --}}
    @include('partials.cta')

@endsection