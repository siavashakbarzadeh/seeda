@extends('layouts.app')
@section('title', 'Contact — Seeda')
@section('meta_description', 'Get in touch with Seeda. Tell us about your project and we will respond within 24 hours.')

@section('content')

    {{-- Page Header --}}
    <section class="py-16 md:py-24 bg-gradient-to-b from-primary-bg to-white">
        <div class="max-w-[1200px] mx-auto px-4 md:px-8 text-center fade-in">
            <h1 class="text-4xl md:text-5xl font-extrabold mb-4">Get in Touch</h1>
            <p class="text-lg text-neutral-600 max-w-xl mx-auto">Have a project in mind? We'd love to hear about it. Drop us
                a message and we'll get back to you within 24 hours.</p>
        </div>
    </section>

    {{-- Contact Form + Sidebar --}}
    <section class="py-16 md:py-24">
        <div class="max-w-[1200px] mx-auto px-4 md:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-5 gap-12">

                {{-- Form --}}
                <div class="lg:col-span-3 fade-in-left">
                    @if (session('success'))
                        <div class="bg-primary-bg border border-primary/20 text-primary rounded-xl p-6 mb-8 text-center">
                            <svg class="w-12 h-12 mx-auto text-primary mb-3" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="font-semibold text-lg">{{ session('success') }}</p>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('contact.submit') }}" class="space-y-6">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-semibold text-neutral-700 mb-2">Full Name
                                    *</label>
                                <input type="text" name="name" id="name" required value="{{ old('name') }}"
                                    class="w-full px-4 py-3 border border-neutral-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all @error('name') border-red-400 @enderror">
                                @error('name') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-semibold text-neutral-700 mb-2">Email *</label>
                                <input type="email" name="email" id="email" required value="{{ old('email') }}"
                                    class="w-full px-4 py-3 border border-neutral-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all @error('email') border-red-400 @enderror">
                                @error('email') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div>
                            <label for="company" class="block text-sm font-semibold text-neutral-700 mb-2">Company</label>
                            <input type="text" name="company" id="company" value="{{ old('company') }}"
                                class="w-full px-4 py-3 border border-neutral-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all">
                        </div>

                        <div>
                            <label for="message" class="block text-sm font-semibold text-neutral-700 mb-2">Message *</label>
                            <textarea name="message" id="message" rows="5" required
                                class="w-full px-4 py-3 border border-neutral-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all resize-none @error('message') border-red-400 @enderror">{{ old('message') }}</textarea>
                            @error('message') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                        </div>

                        <button type="submit"
                            class="w-full md:w-auto px-8 py-3.5 bg-primary text-white font-semibold rounded-xl hover:bg-primary-dark transition-all shadow-md hover:shadow-lg hover:-translate-y-0.5">
                            Send Message
                        </button>
                    </form>
                </div>

                {{-- Sidebar --}}
                <div class="lg:col-span-2 fade-in-right">
                    <div class="bg-neutral-50 rounded-2xl p-8">
                        <h3 class="text-lg font-bold text-neutral-900 mb-6">Contact Information</h3>

                        <div class="space-y-6">
                            <div class="flex gap-4">
                                <div
                                    class="w-10 h-10 bg-primary-bg text-primary rounded-lg flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-sm font-semibold text-neutral-900">Email</h4>
                                    <p class="text-sm text-neutral-600">hello@seeda.dev</p>
                                </div>
                            </div>

                            <div class="flex gap-4">
                                <div
                                    class="w-10 h-10 bg-primary-bg text-primary rounded-lg flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-sm font-semibold text-neutral-900">Phone</h4>
                                    <p class="text-sm text-neutral-600">+39 02 1234 5678</p>
                                </div>
                            </div>

                            <div class="flex gap-4">
                                <div
                                    class="w-10 h-10 bg-primary-bg text-primary rounded-lg flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-sm font-semibold text-neutral-900">Office</h4>
                                    <p class="text-sm text-neutral-600">Milan, Italy</p>
                                </div>
                            </div>

                            <div class="flex gap-4">
                                <div
                                    class="w-10 h-10 bg-primary-bg text-primary rounded-lg flex items-center justify-center shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <h4 class="text-sm font-semibold text-neutral-900">Business Hours</h4>
                                    <p class="text-sm text-neutral-600">Mon – Fri, 9:00 – 18:00 CET</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection