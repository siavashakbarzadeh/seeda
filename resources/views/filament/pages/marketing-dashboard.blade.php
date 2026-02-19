<x-filament-panels::page>
    {{-- Quick Stats Row --}}
    @php $qs = $this->getQuickStats(); @endphp
    <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-8">
        <div
            class="bg-white dark:bg-gray-800 rounded-xl p-4 shadow-sm border border-gray-200 dark:border-gray-700 text-center">
            <p class="text-2xl font-bold text-emerald-600">{{ $qs['new_leads_today'] }}</p>
            <p class="text-xs text-gray-500 mt-1">New Leads Today</p>
        </div>
        <div
            class="bg-white dark:bg-gray-800 rounded-xl p-4 shadow-sm border border-gray-200 dark:border-gray-700 text-center">
            <p class="text-2xl font-bold {{ $qs['unread_submissions'] > 0 ? 'text-red-500' : 'text-gray-400' }}">
                {{ $qs['unread_submissions'] }}</p>
            <p class="text-xs text-gray-500 mt-1">Unread Submissions</p>
        </div>
        <div
            class="bg-white dark:bg-gray-800 rounded-xl p-4 shadow-sm border border-gray-200 dark:border-gray-700 text-center">
            <p class="text-2xl font-bold text-blue-600">{{ $qs['scheduled_emails'] }}</p>
            <p class="text-xs text-gray-500 mt-1">Scheduled Emails</p>
        </div>
        <div
            class="bg-white dark:bg-gray-800 rounded-xl p-4 shadow-sm border border-gray-200 dark:border-gray-700 text-center">
            <p class="text-2xl font-bold text-purple-600">{{ $qs['scheduled_posts'] }}</p>
            <p class="text-xs text-gray-500 mt-1">Scheduled Posts</p>
        </div>
        <div
            class="bg-white dark:bg-gray-800 rounded-xl p-4 shadow-sm border border-gray-200 dark:border-gray-700 text-center">
            <p class="text-2xl font-bold text-emerald-500">{{ $qs['funnel_conversions'] }}</p>
            <p class="text-xs text-gray-500 mt-1">Funnel Conversions</p>
        </div>
    </div>

    {{-- Lead Pipeline --}}
    @php $pipeline = $this->getLeadPipeline(); @endphp
    <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700 mb-8">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">📊 Lead Pipeline</h3>
        <div class="grid grid-cols-2 md:grid-cols-7 gap-3">
            @foreach($pipeline as $stage)
                @php
                    $colors = [
                        'new' => 'bg-blue-50 dark:bg-blue-900/20 border-blue-200 dark:border-blue-800',
                        'contacted' => 'bg-indigo-50 dark:bg-indigo-900/20 border-indigo-200 dark:border-indigo-800',
                        'qualified' => 'bg-yellow-50 dark:bg-yellow-900/20 border-yellow-200 dark:border-yellow-800',
                        'proposal' => 'bg-orange-50 dark:bg-orange-900/20 border-orange-200 dark:border-orange-800',
                        'negotiation' => 'bg-purple-50 dark:bg-purple-900/20 border-purple-200 dark:border-purple-800',
                        'won' => 'bg-emerald-50 dark:bg-emerald-900/20 border-emerald-200 dark:border-emerald-800',
                        'lost' => 'bg-red-50 dark:bg-red-900/20 border-red-200 dark:border-red-800',
                    ];
                    $textColors = [
                        'new' => 'text-blue-700 dark:text-blue-400',
                        'contacted' => 'text-indigo-700 dark:text-indigo-400',
                        'qualified' => 'text-yellow-700 dark:text-yellow-400',
                        'proposal' => 'text-orange-700 dark:text-orange-400',
                        'negotiation' => 'text-purple-700 dark:text-purple-400',
                        'won' => 'text-emerald-700 dark:text-emerald-400',
                        'lost' => 'text-red-700 dark:text-red-400',
                    ];
                @endphp
                <div class="rounded-lg p-3 border {{ $colors[$stage['status']] ?? '' }} text-center">
                    <p class="text-2xl font-bold {{ $textColors[$stage['status']] ?? '' }}">{{ $stage['count'] }}</p>
                    <p class="text-xs font-medium text-gray-600 dark:text-gray-400">{{ $stage['label'] }}</p>
                    <p class="text-xs text-gray-400 mt-1">€{{ number_format($stage['value'], 0) }}</p>
                </div>
            @endforeach
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        {{-- Conversion Funnel --}}
        @php $funnel = $this->getConversionFunnel(); @endphp
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">🔽 Conversion Funnel</h3>
            <div class="space-y-3">
                @foreach($funnel as $step)
                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <span class="text-gray-700 dark:text-gray-300">{{ $step['label'] }}</span>
                            <span class="font-semibold text-gray-900 dark:text-white">{{ $step['count'] }} <span
                                    class="text-gray-400 font-normal">({{ $step['pct'] }}%)</span></span>
                        </div>
                        <div class="w-full bg-gray-100 dark:bg-gray-700 rounded-full h-3">
                            <div class="bg-gradient-to-r from-emerald-500 to-emerald-400 h-3 rounded-full transition-all duration-700"
                                style="width: {{ max($step['pct'], 2) }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Monthly Trends --}}
        @php
            $trends = $this->getMonthlyTrends();
            $maxLeads = max(array_column($trends, 'leads')) ?: 1;
        @endphp
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">📈 Monthly Trends (6 months)</h3>
            <div class="flex items-end gap-3 h-44">
                @foreach($trends as $m)
                    <div class="flex-1 flex flex-col items-center gap-1">
                        <span class="text-xs font-semibold text-emerald-600">{{ $m['leads'] }}</span>
                        <div class="w-full rounded-t transition-all duration-500 relative"
                            style="height: {{ ($m['leads'] / $maxLeads) * 100 }}%">
                            <div class="absolute inset-0 bg-emerald-500/80 rounded-t"></div>
                            @if($m['won'] > 0)
                                <div class="absolute bottom-0 inset-x-0 bg-emerald-700 rounded-t"
                                    style="height: {{ ($m['won'] / max($m['leads'], 1)) * 100 }}%"></div>
                            @endif
                        </div>
                        <span class="text-xs text-gray-500">{{ $m['month'] }}</span>
                        <span class="text-[10px] text-gray-400">€{{ number_format($m['revenue'], 0) }}</span>
                    </div>
                @endforeach
            </div>
            <div class="flex items-center gap-4 mt-3 text-xs text-gray-400">
                <span class="flex items-center gap-1"><span
                        class="w-3 h-3 rounded bg-emerald-500/80 inline-block"></span> Leads</span>
                <span class="flex items-center gap-1"><span class="w-3 h-3 rounded bg-emerald-700 inline-block"></span>
                    Won</span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Top Campaigns --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">🏆 Top Active Campaigns</h3>
            <div class="space-y-3">
                @forelse($this->getTopCampaigns() as $i => $campaign)
                    <div
                        class="flex items-center justify-between py-2 border-b border-gray-100 dark:border-gray-700 last:border-0">
                        <div class="flex items-center gap-3">
                            <span
                                class="w-6 h-6 rounded-full bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 text-xs font-bold flex items-center justify-center">{{ $i + 1 }}</span>
                            <div>
                                <span
                                    class="font-medium text-gray-900 dark:text-white text-sm">{{ $campaign['name'] }}</span>
                                <span class="text-xs text-gray-400 ml-2">{{ $campaign['type'] }}</span>
                            </div>
                        </div>
                        <div class="text-right">
                            <span
                                class="font-semibold {{ $campaign['roi'] > 0 ? 'text-emerald-600' : 'text-red-500' }} text-sm">ROI
                                {{ $campaign['roi'] }}%</span>
                            <p class="text-xs text-gray-400">{{ $campaign['leads'] }} leads ·
                                €{{ number_format($campaign['revenue'], 0) }}</p>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-400 text-sm">No active campaigns.</p>
                @endforelse
            </div>
        </div>

        {{-- Upcoming Follow-ups --}}
        @php $overdue = $this->getOverdueFollowUps(); @endphp
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">📅 Upcoming Follow-ups</h3>
                @if($overdue > 0)
                    <span
                        class="px-2 py-1 text-xs font-bold rounded-full bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400">{{ $overdue }}
                        overdue</span>
                @endif
            </div>
            <div class="space-y-3">
                @forelse($this->getUpcomingFollowUps() as $followUp)
                    <div
                        class="flex items-start justify-between py-2 border-b border-gray-100 dark:border-gray-700 last:border-0">
                        <div>
                            <a href="/admin/leads/{{ $followUp['lead_id'] }}/edit"
                                class="font-medium text-gray-900 dark:text-white text-sm hover:text-emerald-600 transition">
                                {{ $followUp['lead_name'] }}
                            </a>
                            <p class="text-xs text-gray-400 mt-0.5">{{ $followUp['type'] }} —
                                {{ Str::limit($followUp['description'], 50) }}</p>
                        </div>
                        <div class="text-right flex-shrink-0 ml-3">
                            <span
                                class="text-xs font-medium text-gray-600 dark:text-gray-300">{{ $followUp['scheduled_at'] }}</span>
                            <p class="text-xs text-gray-400">{{ $followUp['assigned_to'] }}</p>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-400 text-sm">No upcoming follow-ups. 🎉</p>
                @endforelse
            </div>
        </div>
    </div>
</x-filament-panels::page>