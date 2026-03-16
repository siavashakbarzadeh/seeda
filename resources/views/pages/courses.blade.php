@extends('layouts.app')

@section('title', __('Courses') . ' — Seeda')
@section('description', 'Professional training courses by Seeda Academy')

@section('content')
<div class="min-h-screen" style="background: linear-gradient(135deg, #0a0a0a 0%, #1a1a2e 50%, #0a0a0a 100%);">

    {{-- Hero --}}
    <div class="pt-32 pb-16 px-4 text-center">
        <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">
            {{ __('Academy & Courses') }}
        </h1>
        <p class="text-gray-400 text-lg max-w-2xl mx-auto">
            {{ __('Level up your skills with our professional training programs') }}
        </p>
    </div>

    {{-- Courses Grid --}}
    <div class="max-w-7xl mx-auto px-4 pb-20">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($courses as $course)
                <div class="rounded-2xl overflow-hidden border transition-all duration-300 hover:scale-[1.02] hover:shadow-xl hover:shadow-green-500/10"
                    style="background: rgba(255,255,255,0.03); border-color: rgba(255,255,255,0.08);">

                    @if($course->image)
                        <img src="{{ asset('storage/' . $course->image) }}" alt="{{ $course->title }}" class="w-full h-48 object-cover">
                    @else
                        <div class="w-full h-48 flex items-center justify-center" style="background: linear-gradient(135deg, #16a34a, #15803d);">
                            <svg class="w-16 h-16 text-white/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 14l9-5-9-5-9 5 9 5z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                            </svg>
                        </div>
                    @endif

                    <div class="p-6">
                        <div class="flex items-center gap-2 mb-3">
                            @if($course->level)
                                <span class="text-xs px-2 py-1 rounded-full" style="background: rgba(22,163,74,0.15); color: #86efac;">
                                    {{ ucfirst($course->level) }}
                                </span>
                            @endif
                            @if($course->format)
                                <span class="text-xs px-2 py-1 rounded-full" style="background: rgba(34,211,238,0.15); color: #67e8f9;">
                                    {{ ucfirst($course->format) }}
                                </span>
                            @endif
                        </div>

                        <h3 class="text-xl font-bold text-white mb-2">{{ $course->title }}</h3>
                        <p class="text-gray-400 text-sm mb-4 line-clamp-3">{{ strip_tags($course->subtitle ?? $course->description) }}</p>

                        <div class="flex items-center justify-between mt-4 pt-4" style="border-top: 1px solid rgba(255,255,255,0.08);">
                            @if($course->price)
                                <div>
                                    <span class="text-2xl font-bold text-green-400">€{{ number_format($course->price, 0) }}</span>
                                    @if($course->installment_info)
                                        <span class="text-xs text-gray-500 block">{{ $course->installment_info }}</span>
                                    @endif
                                </div>
                            @endif
                            <a href="{{ route('course.detail', $course->slug) }}"
                                class="px-4 py-2 rounded-lg text-sm font-semibold text-white transition-all hover:shadow-lg hover:shadow-green-500/20"
                                style="background: linear-gradient(135deg, #16a34a, #15803d);">
                                {{ __('Learn More') }}
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-20">
                    <p class="text-gray-500 text-lg">{{ __('No courses available yet.') }}</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
