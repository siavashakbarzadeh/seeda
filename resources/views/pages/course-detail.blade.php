@extends('layouts.app')

@section('title', $course->title . ' — Seeda Academy')
@section('description', strip_tags($course->subtitle ?? $course->description))

@section('content')
<div class="min-h-screen" style="background: linear-gradient(135deg, #0a0a0a 0%, #1a1a2e 50%, #0a0a0a 100%);">

    {{-- Hero --}}
    <div class="pt-32 pb-16 px-4">
        <div class="max-w-4xl mx-auto">
            <a href="{{ route('courses') }}" class="inline-flex items-center gap-1 text-sm text-gray-500 hover:text-green-400 transition-colors mb-6">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                {{ __('All Courses') }}
            </a>

            <div class="flex flex-wrap items-center gap-3 mb-4">
                @if($course->level)
                    <span class="text-sm px-3 py-1 rounded-full" style="background: rgba(22,163,74,0.15); color: #86efac;">
                        {{ ucfirst($course->level) }}
                    </span>
                @endif
                @if($course->format)
                    <span class="text-sm px-3 py-1 rounded-full" style="background: rgba(34,211,238,0.15); color: #67e8f9;">
                        {{ ucfirst($course->format) }}
                    </span>
                @endif
                @if($course->location)
                    <span class="text-sm text-gray-400">📍 {{ $course->location }}</span>
                @endif
            </div>

            <h1 class="text-3xl md:text-5xl font-bold text-white mb-4">{{ $course->title }}</h1>
            @if($course->subtitle)
                <p class="text-xl text-gray-400 mb-8">{{ $course->subtitle }}</p>
            @endif
        </div>
    </div>

    {{-- Content --}}
    <div class="max-w-4xl mx-auto px-4 pb-20">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- Main Content --}}
            <div class="lg:col-span-2 space-y-8">

                {{-- Description --}}
                <div class="rounded-2xl p-6 border"
                    style="background: rgba(255,255,255,0.03); border-color: rgba(255,255,255,0.08);">
                    <h2 class="text-xl font-bold text-white mb-4">{{ __('About This Course') }}</h2>
                    <div class="text-gray-300 prose prose-invert max-w-none">
                        {!! $course->description !!}
                    </div>
                </div>

                {{-- Curriculum --}}
                @if($course->curriculum)
                <div class="rounded-2xl p-6 border"
                    style="background: rgba(255,255,255,0.03); border-color: rgba(255,255,255,0.08);">
                    <h2 class="text-xl font-bold text-white mb-4">📚 {{ __('Curriculum') }}</h2>
                    <div class="text-gray-300 prose prose-invert max-w-none">
                        {!! $course->curriculum !!}
                    </div>
                </div>
                @endif

                {{-- Career Info --}}
                @if($course->career_info)
                <div class="rounded-2xl p-6 border"
                    style="background: rgba(255,255,255,0.03); border-color: rgba(255,255,255,0.08);">
                    <h2 class="text-xl font-bold text-white mb-4">🚀 {{ __('Career Opportunities') }}</h2>
                    <div class="text-gray-300 prose prose-invert max-w-none">
                        {!! $course->career_info !!}
                    </div>
                </div>
                @endif
            </div>

            {{-- Sidebar --}}
            <div class="lg:col-span-1">
                <div class="sticky top-24 rounded-2xl p-6 border"
                    style="background: rgba(255,255,255,0.05); border-color: rgba(255,255,255,0.1);">

                    @if($course->price)
                        <div class="text-center mb-6">
                            <span class="text-4xl font-bold text-green-400">€{{ number_format($course->price, 0) }}</span>
                            @if($course->installment_info)
                                <p class="text-sm text-gray-500 mt-1">💶 {{ $course->installment_info }}</p>
                            @endif
                        </div>
                    @endif

                    <div class="space-y-3 mb-6">
                        @if($course->duration)
                            <div class="flex items-center gap-3 text-gray-300 text-sm">
                                <span>⏱️</span>
                                <span>{{ __('Duration') }}: {{ $course->duration }}</span>
                            </div>
                        @endif
                        @if($course->format)
                            <div class="flex items-center gap-3 text-gray-300 text-sm">
                                <span>💻</span>
                                <span>{{ __('Format') }}: {{ ucfirst($course->format) }}</span>
                            </div>
                        @endif
                        @if($course->location)
                            <div class="flex items-center gap-3 text-gray-300 text-sm">
                                <span>📍</span>
                                <span>{{ $course->location }}</span>
                            </div>
                        @endif
                        @if($course->starts_at)
                            <div class="flex items-center gap-3 text-gray-300 text-sm">
                                <span>📅</span>
                                <span>{{ __('Starts') }}: {{ $course->starts_at->format('d M Y') }}</span>
                            </div>
                        @endif
                    </div>

                    @if($course->link)
                        <a href="{{ $course->link }}" target="_blank"
                            class="block w-full py-3 px-6 rounded-xl font-semibold text-white text-center transition-all duration-300 hover:scale-[1.02] hover:shadow-lg hover:shadow-green-500/20"
                            style="background: linear-gradient(135deg, #16a34a, #15803d);">
                            🚀 {{ __('Enroll Now') }}
                        </a>
                    @endif
                </div>
            </div>
        </div>

        {{-- Related Courses --}}
        @if($relatedCourses->count() > 0)
            <div class="mt-16">
                <h2 class="text-2xl font-bold text-white mb-8">{{ __('Other Courses') }}</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($relatedCourses as $related)
                        <a href="{{ route('course.detail', $related->slug) }}"
                            class="rounded-xl p-5 border transition-all hover:scale-[1.02]"
                            style="background: rgba(255,255,255,0.03); border-color: rgba(255,255,255,0.08);">
                            <h3 class="text-white font-semibold mb-2">{{ $related->title }}</h3>
                            @if($related->price)
                                <span class="text-green-400 font-bold">€{{ number_format($related->price, 0) }}</span>
                            @endif
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
