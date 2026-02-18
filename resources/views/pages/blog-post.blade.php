@extends('layouts.app')
@section('title', $post->seo_title ?? $post->title . ' — Seeda Blog')
@section('meta_description', $post->seo_description ?? $post->excerpt)

@section('content')

    <article class="pt-20 pb-16">
        <div class="max-w-[800px] mx-auto px-4 md:px-8">

            {{-- Breadcrumb --}}
            <nav class="flex items-center gap-2 text-sm text-neutral-400 mb-8 fade-in">
                <a href="{{ route('home') }}" class="hover:text-primary transition-colors">Home</a>
                <span>/</span>
                <a href="{{ route('blog') }}" class="hover:text-primary transition-colors">Blog</a>
                <span>/</span>
                <span class="text-neutral-600">{{ Str::limit($post->title, 40) }}</span>
            </nav>

            {{-- Header --}}
            <div class="fade-in mb-8">
                <div class="flex items-center gap-3 mb-4">
                    @if($post->category)
                        <span class="px-3 py-1 bg-primary-bg text-primary text-xs font-semibold rounded-full">{{ $post->category }}</span>
                    @endif
                    <span class="text-sm text-neutral-400">{{ $post->published_at?->format('F d, Y') }}</span>
                    @if($post->author)
                        <span class="text-sm text-neutral-400">· By {{ $post->author->name ?? $post->author }}</span>
                    @endif
                </div>
                <h1 class="text-3xl md:text-4xl lg:text-5xl font-extrabold leading-tight mb-4">{{ $post->title }}</h1>
                @if($post->excerpt)
                    <p class="text-lg text-neutral-600 leading-relaxed">{{ $post->excerpt }}</p>
                @endif
            </div>

            {{-- Featured Image --}}
            @if($post->featured_image)
                <div class="aspect-[16/9] rounded-2xl overflow-hidden mb-10">
                    <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}"
                         class="w-full h-full object-cover">
                </div>
            @endif

            {{-- Content --}}
            <div class="prose prose-lg prose-neutral max-w-none
                        prose-headings:font-bold prose-headings:text-neutral-900
                        prose-a:text-primary prose-a:no-underline hover:prose-a:underline
                        prose-img:rounded-xl prose-img:shadow-md
                        prose-code:text-primary prose-code:bg-primary-bg prose-code:px-1.5 prose-code:py-0.5 prose-code:rounded
                        prose-pre:bg-neutral-900 prose-pre:rounded-xl">
                {!! $post->body !!}
            </div>

            {{-- Tags --}}
            @if($post->tags && count($post->tags))
                <div class="flex flex-wrap gap-2 mt-10 pt-8 border-t border-neutral-200">
                    @foreach($post->tags as $tag)
                        <span class="px-3 py-1.5 bg-neutral-100 text-neutral-600 text-xs font-medium rounded-full">#{{ $tag }}</span>
                    @endforeach
                </div>
            @endif

            {{-- Share --}}
            <div class="flex items-center gap-4 mt-8 pt-8 border-t border-neutral-200">
                <span class="text-sm font-semibold text-neutral-500">Share:</span>
                <a href="https://twitter.com/intent/tweet?text={{ urlencode($post->title) }}&url={{ urlencode(request()->url()) }}"
                   target="_blank" class="w-9 h-9 rounded-full bg-neutral-100 flex items-center justify-center hover:bg-primary hover:text-white transition-all">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                </a>
                <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(request()->url()) }}&title={{ urlencode($post->title) }}"
                   target="_blank" class="w-9 h-9 rounded-full bg-neutral-100 flex items-center justify-center hover:bg-primary hover:text-white transition-all">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                </a>
            </div>
        </div>
    </article>

    {{-- Related Posts --}}
    @if($related->isNotEmpty())
        <section class="py-16 bg-neutral-50">
            <div class="max-w-[1200px] mx-auto px-4 md:px-8">
                <h2 class="text-2xl font-bold text-center mb-10">Related Posts</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @foreach($related as $rel)
                        <a href="{{ route('blog.post', $rel->slug) }}"
                           class="bg-white rounded-2xl border border-neutral-100 p-6 hover:shadow-xl hover:-translate-y-2 transition-all duration-400 group">
                            <span class="text-xs text-primary font-semibold">{{ $rel->category }}</span>
                            <h3 class="text-lg font-bold mt-2 mb-2 group-hover:text-primary transition-colors">{{ $rel->title }}</h3>
                            <p class="text-sm text-neutral-500 line-clamp-2">{{ $rel->excerpt }}</p>
                            <span class="text-xs text-neutral-400 mt-3 block">{{ $rel->published_at?->format('M d, Y') }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

@endsection
