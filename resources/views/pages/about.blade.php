@extends('layouts.app')
@section('title', 'About — Seeda')
@section('meta_description', 'Meet the team behind Seeda. Engineers, designers, and strategists on a mission to help businesses grow.')

@section('content')

    {{-- Page Header --}}
    <section class="py-16 md:py-24 bg-gradient-to-b from-primary-bg to-white">
        <div class="max-w-[1200px] mx-auto px-4 md:px-8 text-center fade-in">
            <h1 class="text-4xl md:text-5xl font-extrabold mb-4">About Seeda</h1>
            <p class="text-lg text-neutral-600 max-w-xl mx-auto">We're a team of engineers, designers, and strategists on a
                mission to help businesses grow through technology.</p>
        </div>
    </section>

    {{-- Mission --}}
    <section class="py-16 md:py-24">
        <div class="max-w-[720px] mx-auto px-4 text-center fade-in">
            <h2 class="text-3xl font-bold mb-8">Our Story</h2>
            <p class="text-lg text-neutral-600 leading-relaxed mb-6">
                Seeda was founded on a simple belief: <strong>great software starts with great relationships</strong>.
                We partner closely with our clients to understand their challenges, then design and build solutions
                that are not just technically excellent — but transformative for their business.
            </p>
            <p class="text-lg text-neutral-600 leading-relaxed">
                Our name comes from the idea of <strong>planting seeds</strong>. Every project we take on is a seed —
                nurtured with precision, expertise, and care — that grows into lasting impact.
            </p>
        </div>
    </section>

    {{-- Values --}}
    <section class="py-16 md:py-24 bg-neutral-50">
        <div class="max-w-[1200px] mx-auto px-4 md:px-8">
            <div class="text-center mb-12 fade-in">
                <span class="text-sm font-semibold text-primary uppercase tracking-wider">Our Values</span>
                <h2 class="text-3xl font-bold mt-3 mb-4">What Drives Us</h2>
                <div class="w-12 h-1 bg-primary rounded-full mx-auto mb-4"></div>
            </div>

            @php
                $values = [
                    ['icon' => '🎯', 'title' => 'Impact-Driven', 'desc' => 'Every line of code serves a purpose. We focus on solutions that create real value.'],
                    ['icon' => '🤝', 'title' => 'Client Partnership', 'desc' => "We treat every project like it's our own. Transparent communication at every step."],
                    ['icon' => '⚡', 'title' => 'Technical Excellence', 'desc' => 'Modern stacks, clean architecture, battle-tested practices.'],
                    ['icon' => '🛡️', 'title' => 'Reliability', 'desc' => 'We deliver on time, within budget, and stand behind our work long after launch.'],
                ];
            @endphp

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach ($values as $i => $value)
                    <div
                        class="zoom-in stagger-{{ $i + 1 }} bg-white rounded-2xl p-8 text-center border border-neutral-100 hover:shadow-lg hover:-translate-y-1 transition-all">
                        <div class="text-4xl mb-4">{{ $value['icon'] }}</div>
                        <h3 class="text-lg font-bold text-neutral-900 mb-2">{{ $value['title'] }}</h3>
                        <p class="text-sm text-neutral-600 leading-relaxed">{{ $value['desc'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Team --}}
    <section class="py-16 md:py-24">
        <div class="max-w-[1200px] mx-auto px-4 md:px-8">
            <div class="text-center mb-12 fade-in">
                <span class="text-sm font-semibold text-primary uppercase tracking-wider">Our Team</span>
                <h2 class="text-3xl font-bold mt-3 mb-4">Meet the People Behind Seeda</h2>
                <div class="w-12 h-1 bg-primary rounded-full mx-auto mb-4"></div>
            </div>

            @php
                $avatarColors = ['#16A34A', '#2563EB', '#9333EA', '#EA580C', '#F59E0B', '#EC4899'];
            @endphp

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($team as $i => $member)
                    <div
                        class="zoom-in stagger-{{ ($i % 3) + 1 }} bg-white rounded-2xl border border-neutral-100 p-8 text-center hover:shadow-xl hover:-translate-y-2 transition-all duration-400">
                        {{-- Avatar --}}
                        <div class="w-20 h-20 rounded-full mx-auto mb-5 flex items-center justify-center text-white text-2xl font-bold"
                            style="background: {{ $avatarColors[$i % count($avatarColors)] }};">
                            {{ $member->initials }}
                        </div>
                        <h3 class="text-lg font-bold text-neutral-900">{{ $member->name }}</h3>
                        <p class="text-sm text-primary font-medium mb-3">{{ $member->role }}</p>
                        <p class="text-sm text-neutral-600 leading-relaxed mb-4">{{ $member->bio }}</p>
                        @if ($member->linkedin)
                            <a href="{{ $member->linkedin }}" target="_blank" rel="noopener"
                                class="text-neutral-400 hover:text-primary transition-colors">
                                <svg class="w-5 h-5 mx-auto" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
                                </svg>
                            </a>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    @include('partials.cta')

@endsection