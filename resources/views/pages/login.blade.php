@extends('layouts.app')

@section('title', 'Login — Seeda')
@section('description', 'Sign in to your Seeda account')

@section('content')
    <div class="min-h-screen flex items-center justify-center px-4 py-16 relative overflow-hidden"
        style="background: linear-gradient(135deg, #0a0a0a 0%, #1a1a2e 50%, #0a0a0a 100%);">

        {{-- Background decorations --}}
        <div class="absolute top-0 left-0 w-full h-full pointer-events-none overflow-hidden">
            <div class="absolute -top-40 -right-40 w-96 h-96 rounded-full opacity-10"
                style="background: radial-gradient(circle, #16a34a, transparent);"></div>
            <div class="absolute -bottom-40 -left-40 w-96 h-96 rounded-full opacity-10"
                style="background: radial-gradient(circle, #22d3ee, transparent);"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] rounded-full opacity-5"
                style="background: radial-gradient(circle, #16a34a, transparent);"></div>
        </div>

        <div class="relative z-10 w-full max-w-md">

            {{-- Logo --}}
            <div class="text-center mb-8">
                <a href="/" class="inline-flex items-center gap-3 group">
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center text-white font-bold text-xl"
                        style="background: linear-gradient(135deg, #16a34a, #22d3ee);">
                        S
                    </div>
                    <span class="text-2xl font-bold text-white group-hover:text-green-400 transition-colors">Seeda</span>
                </a>
                <p class="text-gray-400 mt-3 text-sm">Sign in to your account</p>
            </div>

            {{-- Login Card --}}
            <div class="rounded-2xl p-8 border"
                style="background: rgba(255,255,255,0.03); border-color: rgba(255,255,255,0.08); backdrop-filter: blur(20px);">

                {{-- Error Messages --}}
                @if ($errors->any())
                    <div class="mb-6 p-4 rounded-xl text-sm"
                        style="background: rgba(239,68,68,0.1); border: 1px solid rgba(239,68,68,0.2); color: #fca5a5;">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                {{-- Success Message --}}
                @if (session('status'))
                    <div class="mb-6 p-4 rounded-xl text-sm"
                        style="background: rgba(22,163,106,0.1); border: 1px solid rgba(22,163,106,0.2); color: #86efac;">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="/login" class="space-y-5">
                    @csrf

                    {{-- Email --}}
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-300 mb-2">Email Address</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                                placeholder="you@company.com"
                                class="w-full pl-12 pr-4 py-3 rounded-xl text-white placeholder-gray-500 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-green-500/40"
                                style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);"
                                onfocus="this.style.borderColor='rgba(22,163,74,0.5)'"
                                onblur="this.style.borderColor='rgba(255,255,255,0.1)'">
                        </div>
                    </div>

                    {{-- Password --}}
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-300 mb-2">Password</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <input type="password" id="password" name="password" required placeholder="••••••••"
                                class="w-full pl-12 pr-4 py-3 rounded-xl text-white placeholder-gray-500 transition-all duration-300 focus:outline-none focus:ring-2 focus:ring-green-500/40"
                                style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);"
                                onfocus="this.style.borderColor='rgba(22,163,74,0.5)'"
                                onblur="this.style.borderColor='rgba(255,255,255,0.1)'">
                        </div>
                    </div>

                    {{-- Remember + Forgot --}}
                    <div class="flex items-center justify-between">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="remember"
                                class="w-4 h-4 rounded accent-green-500 bg-transparent border-gray-600">
                            <span class="text-sm text-gray-400">Remember me</span>
                        </label>
                    </div>

                    {{-- Submit --}}
                    <button type="submit"
                        class="w-full py-3 px-6 rounded-xl font-semibold text-white transition-all duration-300 transform hover:scale-[1.02] hover:shadow-lg hover:shadow-green-500/20 active:scale-[0.98]"
                        style="background: linear-gradient(135deg, #16a34a, #15803d);">
                        <span class="flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                            </svg>
                            Sign In
                        </span>
                    </button>
                </form>
            </div>

            {{-- Footer links --}}
            <div class="mt-8 text-center space-y-3">
                <a href="/"
                    class="inline-flex items-center gap-1 text-sm text-gray-500 hover:text-green-400 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to website
                </a>
            </div>

            {{-- Demo credentials --}}
            <div class="mt-6 rounded-xl p-4 text-center"
                style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.06);">
                <p class="text-xs text-gray-500 mb-2">Demo Accounts</p>
                <div class="grid grid-cols-2 gap-3 text-xs">
                    <div class="rounded-lg p-2" style="background: rgba(22,163,74,0.08);">
                        <p class="text-green-400 font-medium">Admin</p>
                        <p class="text-gray-400 mt-1">admin@seeda.dev</p>
                    </div>
                    <div class="rounded-lg p-2" style="background: rgba(34,211,238,0.08);">
                        <p class="text-cyan-400 font-medium">Client</p>
                        <p class="text-gray-400 mt-1">client@acme.com</p>
                    </div>
                </div>
                <p class="text-gray-600 text-xs mt-2">Password: <code class="text-gray-400">password</code></p>
            </div>
        </div>
    </div>
@endsection