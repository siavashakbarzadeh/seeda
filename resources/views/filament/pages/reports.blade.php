<x-filament-panels::page>
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">
        {{-- Revenue --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-10 h-10 rounded-lg bg-green-100 dark:bg-green-900/30 flex items-center justify-center">
                    <x-heroicon-o-currency-euro class="w-5 h-5 text-green-600" />
                </div>
                <span class="text-sm text-gray-500">Revenue (Paid)</span>
            </div>
            <p class="text-2xl font-bold text-gray-900 dark:text-white">
                €{{ number_format(\App\Models\Invoice::where('status', 'paid')->sum('total'), 0) }}
            </p>
        </div>

        {{-- Projects --}}
        @php $ps = $this->getProjectStats(); @endphp
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-10 h-10 rounded-lg bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                    <x-heroicon-o-rectangle-stack class="w-5 h-5 text-blue-600" />
                </div>
                <span class="text-sm text-gray-500">Projects</span>
            </div>
            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $ps['total'] }}</p>
            <p class="text-xs text-gray-400 mt-1">{{ $ps['active'] }} active · {{ $ps['completed'] }} completed · <span
                    class="text-red-500">{{ $ps['overdue'] }} overdue</span></p>
        </div>

        {{-- Hours --}}
        @php $ts = $this->getTimeStats(); @endphp
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-10 h-10 rounded-lg bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center">
                    <x-heroicon-o-clock class="w-5 h-5 text-purple-600" />
                </div>
                <span class="text-sm text-gray-500">Hours This Month</span>
            </div>
            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($ts['total_hours'], 1) }}h</p>
            <p class="text-xs text-gray-400 mt-1">{{ number_format($ts['billable_hours'], 1) }}h billable</p>
        </div>

        {{-- Expenses --}}
        @php $es = $this->getExpenseStats(); @endphp
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="flex items-center gap-3 mb-2">
                <div class="w-10 h-10 rounded-lg bg-red-100 dark:bg-red-900/30 flex items-center justify-center">
                    <x-heroicon-o-banknotes class="w-5 h-5 text-red-600" />
                </div>
                <span class="text-sm text-gray-500">Expenses This Month</span>
            </div>
            <p class="text-2xl font-bold text-gray-900 dark:text-white">€{{ number_format($es['total'], 0) }}</p>
        </div>
    </div>

    {{-- Revenue Chart --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700 mb-8">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">📈 Monthly Revenue (Last 12 Months)</h3>
        @php $revenue = $this->getRevenueData();
        $maxRev = max(array_column($revenue, 'revenue')) ?: 1; @endphp
        <div class="flex items-end gap-2 h-48">
            @foreach($revenue as $m)
                <div class="flex-1 flex flex-col items-center gap-1">
                    <span class="text-xs text-gray-400">€{{ number_format($m['revenue'], 0) }}</span>
                    <div class="w-full bg-emerald-500/80 rounded-t transition-all duration-500"
                        style="height: {{ ($m['revenue'] / $maxRev) * 100 }}%"></div>
                    <span class="text-xs text-gray-500">{{ $m['month'] }}</span>
                </div>
            @endforeach
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        {{-- Top Clients --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">🏆 Top Clients by Revenue</h3>
            <div class="space-y-3">
                @foreach($this->getTopClients() as $i => $client)
                    <div
                        class="flex items-center justify-between py-2 border-b border-gray-100 dark:border-gray-700 last:border-0">
                        <div class="flex items-center gap-3">
                            <span
                                class="w-6 h-6 rounded-full bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 text-xs font-bold flex items-center justify-center">{{ $i + 1 }}</span>
                            <span class="font-medium text-gray-900 dark:text-white">{{ $client['name'] }}</span>
                        </div>
                        <span class="font-semibold text-emerald-600">€{{ number_format($client['revenue'], 0) }}</span>
                    </div>
                @endforeach
                @if(empty($this->getTopClients()))
                    <p class="text-gray-400 text-sm">No client revenue data yet.</p>
                @endif
            </div>
        </div>

        {{-- Expense Breakdown --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">💸 Expense Breakdown (This Month)</h3>
            <div class="space-y-3">
                @foreach($es['by_category'] as $cat => $amount)
                    <div
                        class="flex items-center justify-between py-2 border-b border-gray-100 dark:border-gray-700 last:border-0">
                        <span class="capitalize text-gray-700 dark:text-gray-300">{{ str_replace('_', ' ', $cat) }}</span>
                        <span class="font-semibold text-red-500">€{{ number_format($amount, 0) }}</span>
                    </div>
                @endforeach
                @if(empty($es['by_category']))
                    <p class="text-gray-400 text-sm">No expenses this month.</p>
                @endif
            </div>
        </div>
    </div>
</x-filament-panels::page>