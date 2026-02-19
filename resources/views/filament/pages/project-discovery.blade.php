<x-filament-panels::page>
    {{-- Stats Overview --}}
    @php $stats = $this->getStats(); @endphp
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <div
            class="bg-white dark:bg-gray-800 rounded-xl p-4 shadow-sm border border-gray-200 dark:border-gray-700 text-center">
            <p class="text-2xl font-bold text-blue-600">{{ $stats['active'] }}</p>
            <p class="text-xs text-gray-500 mt-1">Active Opportunities</p>
        </div>
        <div
            class="bg-white dark:bg-gray-800 rounded-xl p-4 shadow-sm border border-gray-200 dark:border-gray-700 text-center">
            <p class="text-2xl font-bold text-purple-600">{{ $stats['applied'] + $stats['interviewing'] }}</p>
            <p class="text-xs text-gray-500 mt-1">In Progress</p>
        </div>
        <div
            class="bg-white dark:bg-gray-800 rounded-xl p-4 shadow-sm border border-gray-200 dark:border-gray-700 text-center">
            <p class="text-2xl font-bold text-emerald-600">{{ $stats['won'] }}</p>
            <p class="text-xs text-gray-500 mt-1">Won ({{ $stats['win_rate'] }}% rate)</p>
        </div>
        <div
            class="bg-white dark:bg-gray-800 rounded-xl p-4 shadow-sm border border-gray-200 dark:border-gray-700 text-center">
            <p class="text-2xl font-bold text-emerald-500">€{{ number_format($stats['total_won_value'], 0) }}</p>
            <p class="text-xs text-gray-500 mt-1">Total Won Value</p>
        </div>
    </div>

    {{-- Workflow Steps --}}
    @php $workflow = $this->getWorkflow(); @endphp
    <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700 mb-8">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">🛤️ مراحل پیدا کردن پروژه</h3>
        <div class="grid grid-cols-1 md:grid-cols-7 gap-3">
            @foreach($workflow as $w)
                <div class="text-center p-3 bg-gray-50 dark:bg-gray-700/30 rounded-lg relative">
                    <span class="text-2xl">{{ $w['icon'] }}</span>
                    <p class="text-xs font-bold text-gray-900 dark:text-white mt-1">{{ $w['step'] }}. {{ $w['title'] }}</p>
                    <p class="text-[10px] text-gray-400 mt-0.5">{{ $w['desc'] }}</p>
                    @if(!$loop->last)
                        <span
                            class="hidden md:block absolute top-1/2 -right-2 text-gray-300 dark:text-gray-600 text-lg">→</span>
                    @endif
                </div>
            @endforeach
        </div>
    </div>

    {{-- Source Performance --}}
    @php $sources = $this->getSourceBreakdown(); @endphp
    @if(!empty($sources))
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700 mb-8">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">📊 عملکرد هر کانال</h3>
            <div class="space-y-3">
                @php $maxTotal = collect($sources)->max('total') ?: 1; @endphp
                @foreach($sources as $src)
                    <div class="flex items-center gap-4">
                        <div class="w-32 text-sm font-medium text-gray-700 dark:text-gray-300">{{ $src['source'] }}</div>
                        <div class="flex-1">
                            <div class="w-full bg-gray-100 dark:bg-gray-700 rounded-full h-5 relative">
                                <div class="bg-blue-500/60 h-5 rounded-full transition-all duration-500"
                                    style="width: {{ ($src['total'] / $maxTotal) * 100 }}%"></div>
                                @if($src['won'] > 0)
                                    <div class="absolute top-0 left-0 bg-emerald-500 h-5 rounded-full transition-all duration-500"
                                        style="width: {{ ($src['won'] / $maxTotal) * 100 }}%"></div>
                                @endif
                            </div>
                        </div>
                        <div class="w-28 text-right">
                            <span class="text-sm font-semibold text-gray-900 dark:text-white">{{ $src['total'] }} total</span>
                            <span class="text-xs text-emerald-600 ml-1">({{ $src['won'] }} won)</span>
                        </div>
                    </div>
                @endforeach
                <div class="flex items-center gap-4 mt-2 text-xs text-gray-400">
                    <span class="flex items-center gap-1"><span class="w-3 h-3 rounded bg-blue-500/60 inline-block"></span>
                        Applied</span>
                    <span class="flex items-center gap-1"><span class="w-3 h-3 rounded bg-emerald-500 inline-block"></span>
                        Won</span>
                </div>
            </div>
        </div>
    @endif

    {{-- Channel Strategies --}}
    @php $channels = $this->getChannels(); @endphp
    <div class="mb-4">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">🗺️ کانال‌ها و استراتژی‌ها</h3>
        <p class="text-sm text-gray-400">هر کانال رو بخون و نکات رو اجرا کن</p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4">
        @foreach($channels as $ch)
            <div
                class="bg-white dark:bg-gray-800 rounded-xl p-5 shadow-sm border border-gray-200 dark:border-gray-700 hover:border-emerald-300 dark:hover:border-emerald-700 transition-all">
                <div class="flex items-center justify-between mb-3">
                    <div class="flex items-center gap-2">
                        <span class="text-xl">{{ $ch['icon'] }}</span>
                        <div>
                            <h4 class="font-bold text-gray-900 dark:text-white text-sm">{{ $ch['name'] }}</h4>
                            <span class="text-[10px] text-gray-400">{{ $ch['type'] }}</span>
                        </div>
                    </div>
                    @if($ch['url'])
                        <a href="{{ $ch['url'] }}" target="_blank" class="text-blue-500 hover:text-blue-600 transition">
                            <x-heroicon-o-arrow-top-right-on-square class="w-4 h-4" />
                        </a>
                    @endif
                </div>
                <ul class="space-y-1.5" dir="rtl">
                    @foreach($ch['tips'] as $tip)
                        <li class="text-xs text-gray-600 dark:text-gray-300 flex items-start gap-1">
                            <span class="text-emerald-500 mt-0.5 flex-shrink-0">✓</span>
                            <span>{{ $tip }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endforeach
    </div>

    {{-- Quick Actions --}}
    <div class="mt-8 bg-gradient-to-r from-emerald-500 to-emerald-600 rounded-xl p-6 shadow-sm">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="text-white">
                <h3 class="text-lg font-bold">🚀 شروع کن!</h3>
                <p class="text-sm text-emerald-100">پروژه‌ای پیدا کردی؟ ثبتش کن و پیگیری کن</p>
            </div>
            <a href="/admin/project-opportunities/create"
                class="px-6 py-3 bg-white text-emerald-600 font-bold rounded-lg hover:bg-emerald-50 transition text-center text-sm">
                ➕ ثبت فرصت جدید
            </a>
        </div>
    </div>
</x-filament-panels::page>