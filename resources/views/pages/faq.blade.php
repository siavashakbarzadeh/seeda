@extends('layouts.app')
@section('title', 'FAQ — Seeda')
@section('meta_description', 'Frequently asked questions about Seeda software consulting services, process, pricing, and support.')

@section('content')

    {{-- Hero --}}
    <section class="pt-20 pb-12 bg-gradient-to-br from-white to-primary-bg">
        <div class="max-w-[1200px] mx-auto px-4 md:px-8 text-center fade-in">
            <span class="text-sm font-semibold text-primary uppercase tracking-wider">FAQ</span>
            <h1 class="text-4xl md:text-5xl font-extrabold mt-3 mb-4">Frequently Asked Questions</h1>
            <div class="w-12 h-1 bg-primary rounded-full mx-auto mb-4"></div>
            <p class="text-lg text-neutral-600 max-w-xl mx-auto">
                Everything you need to know about working with Seeda. Can't find your answer? <a
                    href="{{ route('contact') }}" class="text-primary font-semibold hover:underline">Contact us</a>.
            </p>
        </div>
    </section>

    {{-- FAQ Categories + Accordion --}}
    <section class="py-16">
        <div class="max-w-[800px] mx-auto px-4 md:px-8">

            {{-- Category Filter --}}
            @if($categories->isNotEmpty())
                <div class="flex flex-wrap gap-2 justify-center mb-10 fade-in">
                    <button onclick="filterFaq('all')"
                        class="faq-filter active px-4 py-2 rounded-full text-sm font-medium bg-primary text-white transition-all"
                        data-category="all">
                        All
                    </button>
                    @foreach($categories as $cat)
                        <button onclick="filterFaq('{{ Str::slug($cat) }}')"
                            class="faq-filter px-4 py-2 rounded-full text-sm font-medium bg-neutral-100 text-neutral-600 hover:bg-primary hover:text-white transition-all"
                            data-category="{{ Str::slug($cat) }}">
                            {{ $cat }}
                        </button>
                    @endforeach
                </div>
            @endif

            {{-- Accordion --}}
            <div class="space-y-3" id="faq-list">
                @foreach($faqs as $i => $faq)
                    <div class="faq-item fade-in bg-white rounded-xl border border-neutral-200 overflow-hidden transition-all hover:border-primary/30"
                        data-category="{{ Str::slug($faq->category) }}">
                        <button onclick="toggleFaq(this)"
                            class="w-full flex items-center justify-between px-6 py-5 text-left group">
                            <span
                                class="text-base font-semibold text-neutral-900 group-hover:text-primary transition-colors pr-4">
                                {{ $faq->question }}
                            </span>
                            <svg class="faq-icon w-5 h-5 text-neutral-400 transition-transform duration-300 shrink-0"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div class="faq-answer hidden px-6 pb-5">
                            <div class="text-sm text-neutral-600 leading-relaxed prose prose-sm max-w-none">
                                {!! $faq->answer !!}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            @if($faqs->isEmpty())
                <div class="text-center py-16">
                    <p class="text-neutral-500">No FAQs yet. Check back soon!</p>
                </div>
            @endif
        </div>
    </section>

    {{-- CTA --}}
    <section class="py-16 bg-neutral-50">
        <div class="max-w-[600px] mx-auto px-4 text-center fade-in">
            <h2 class="text-2xl font-bold mb-4">Still Have Questions?</h2>
            <p class="text-neutral-600 mb-6">Our team is happy to help. Get in touch and we'll respond within 24 hours.</p>
            <a href="{{ route('contact') }}"
                class="inline-flex items-center px-7 py-3.5 bg-primary text-white font-semibold rounded-xl hover:bg-primary-dark transition-all shadow-md hover:shadow-lg">
                Contact Us
            </a>
        </div>
    </section>

    <script>
        function toggleFaq(btn) {
            const answer = btn.nextElementSibling;
            const icon = btn.querySelector('.faq-icon');
            const isOpen = !answer.classList.contains('hidden');

            document.querySelectorAll('.faq-answer').forEach(a => a.classList.add('hidden'));
            document.querySelectorAll('.faq-icon').forEach(i => i.style.transform = 'rotate(0deg)');

            if (!isOpen) {
                answer.classList.remove('hidden');
                icon.style.transform = 'rotate(180deg)';
            }
        }

        function filterFaq(category) {
            document.querySelectorAll('.faq-filter').forEach(btn => {
                btn.classList.remove('bg-primary', 'text-white');
                btn.classList.add('bg-neutral-100', 'text-neutral-600');
            });
            event.target.classList.remove('bg-neutral-100', 'text-neutral-600');
            event.target.classList.add('bg-primary', 'text-white');

            document.querySelectorAll('.faq-item').forEach(item => {
                if (category === 'all' || item.dataset.category === category) {
                    item.style.display = '';
                } else {
                    item.style.display = 'none';
                }
            });
        }
    </script>

@endsection