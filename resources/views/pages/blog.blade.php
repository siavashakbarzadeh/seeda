@extends('layouts.app')
@section('title', 'Blog — Seeda')
@section('meta_description', 'Insights, tutorials, and updates from the Seeda team on software development, AI, cloud, and digital strategy.')

@section('content')

    {{-- Hero --}}
    <section class="pt-20 pb-12 bg-gradient-to-br from-white to-primary-bg">
        <div class="max-w-[1200px] mx-auto px-4 md:px-8 text-center fade-in">
            <span class="text-sm font-semibold text-primary uppercase tracking-wider">Our Blog</span>
            <h1 class="text-4xl md:text-5xl font-extrabold mt-3 mb-4">Insights & Updates</h1>
            <div class="w-12 h-1 bg-primary rounded-full mx-auto mb-4"></div>
            <p class="text-lg text-neutral-600 max-w-xl mx-auto">
                Dive into our latest thinking on software, AI, cloud architecture, and building great products.
            </p>
        </div>
    </section>

    {{-- Posts Grid --}}
    <section class="py-16">
        <div class="max-w-[1200px] mx-auto px-4 md:px-8">
            @if($posts->isEmpty())
                <div class="text-center py-20">
                    <div class="w-20 h-20 bg-neutral-100 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-neutral-900 mb-2">No Posts Yet</h3>
                    <p class="text-neutral-500">We're working on some great content. Check back soon!</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($posts as $i => $post)
                        <article
                            class="zoom-in stagger-{{ ($i % 3) + 1 }} bg-white rounded-2xl border border-neutral-100 overflow-hidden hover:shadow-xl hover:-translate-y-2 transition-all duration-400 group">
                            {{-- Thumbnail --}}
                            <div class="aspect-[16/9] bg-gradient-to-br from-primary-bg to-neutral-100 overflow-hidden">
                                @if($post->featured_image)
                                    <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-4xl font-bold text-primary/20">
                                        {{ substr($post->title, 0, 2) }}
                                    </div>
                                @endif
                            </div>

                            <div class="p-6">
                                <div class="flex items-center gap-3 mb-3">
                                    @if($post->category)
                                        <span
                                            class="px-3 py-1 bg-primary-bg text-primary text-xs font-semibold rounded-full">{{ $post->category }}</span>
                                    @endif
                                    <span class="text-xs text-neutral-400">{{ $post->published_at?->format('M d, Y') }}</span>
                                </div>
                                <h2
                                    class="text-lg font-bold text-neutral-900 mb-2 line-clamp-2 group-hover:text-primary transition-colors">
                                    <a href="{{ route('blog.post', $post->slug) }}">{{ $post->title }}</a>
                                </h2>
                                <p class="text-sm text-neutral-600 line-clamp-3 mb-4">{{ $post->excerpt }}</p>
                                <a href="{{ route('blog.post', $post->slug) }}"
                                    class="inline-flex items-center text-sm font-semibold text-primary hover:gap-3 transition-all gap-2">
                                    Read More
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            </div>
                        </article>
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="mt-12">
                    {{ $posts->links() }}
                </div>
            @endif
        </div>
    </section>

@endsection