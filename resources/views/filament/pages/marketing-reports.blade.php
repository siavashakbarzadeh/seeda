<x-filament-panels::page>
    {{-- Campaign Performance Comparison --}}
    @php $campaigns = $this->getCampaignComparison(); @endphp
    <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700 mb-8">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">📊 Campaign Performance Comparison</h3>
        @if(!empty($campaigns))
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-200 dark:border-gray-700">
                            <th class="text-left py-2 px-3 text-gray-500 font-medium">Campaign</th>
                            <th class="text-right py-2 px-3 text-gray-500 font-medium">Budget</th>
                            <th class="text-right py-2 px-3 text-gray-500 font-medium">Spent</th>
                            <th class="text-right py-2 px-3 text-gray-500 font-medium">Revenue</th>
                            <th class="text-right py-2 px-3 text-gray-500 font-medium">ROI</th>
                            <th class="text-right py-2 px-3 text-gray-500 font-medium">Clicks</th>
                            <th class="text-right py-2 px-3 text-gray-500 font-medium">Conversions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($campaigns as $c)
                            <tr
                                class="border-b border-gray-100 dark:border-gray-700/50 hover:bg-gray-50 dark:hover:bg-gray-700/30">
                                <td class="py-2 px-3 font-medium text-gray-900 dark:text-white">{{ $c['name'] }}</td>
                                <td class="py-2 px-3 text-right text-gray-600 dark:text-gray-300">
                                    €{{ number_format($c['budget'], 0) }}</td>
                                <td
                                    class="py-2 px-3 text-right {{ $c['spent'] > $c['budget'] ? 'text-red-500' : 'text-gray-600 dark:text-gray-300' }}">
                                    €{{ number_format($c['spent'], 0) }}</td>
                                <td class="py-2 px-3 text-right font-semibold text-emerald-600">
                                    €{{ number_format($c['revenue'], 0) }}</td>
                                <td class="py-2 px-3 text-right">
                                    <span
                                        class="px-2 py-0.5 rounded-full text-xs font-bold {{ $c['roi'] > 0 ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400' : 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400' }}">
                                        {{ $c['roi'] }}%
                                    </span>
                                </td>
                                <td class="py-2 px-3 text-right text-gray-600 dark:text-gray-300">
                                    {{ number_format($c['clicks']) }}</td>
                                <td class="py-2 px-3 text-right font-semibold text-blue-600">{{ $c['conversions'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-400 text-sm">No campaign data available.</p>
        @endif
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        {{-- Channel Attribution --}}
        @php $channels = $this->getChannelAttribution(); @endphp
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">🎯 Channel Attribution (Won Leads)</h3>
            <div class="space-y-3">
                @php $maxRevenue = collect($channels)->max('revenue') ?: 1; @endphp
                @forelse($channels as $ch)
                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <span class="text-gray-700 dark:text-gray-300">{{ $ch['source'] }}</span>
                            <span class="font-semibold text-gray-900 dark:text-white">{{ $ch['count'] }} deals ·
                                €{{ number_format($ch['revenue'], 0) }}</span>
                        </div>
                        <div class="w-full bg-gray-100 dark:bg-gray-700 rounded-full h-2.5">
                            <div class="bg-gradient-to-r from-blue-500 to-blue-400 h-2.5 rounded-full transition-all duration-700"
                                style="width: {{ ($ch['revenue'] / $maxRevenue) * 100 }}%"></div>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-400 text-sm">No won leads yet.</p>
                @endforelse
            </div>
        </div>

        {{-- Monthly Conversion Rates --}}
        @php $conversionData = $this->getLeadConversionByMonth(); @endphp
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">📈 Monthly Conversion Rate</h3>
            <div class="space-y-3">
                @foreach($conversionData as $m)
                    <div
                        class="flex items-center justify-between py-2 border-b border-gray-100 dark:border-gray-700 last:border-0">
                        <div>
                            <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $m['month'] }}</span>
                            <span class="text-xs text-gray-400 ml-2">{{ $m['created'] }} leads → {{ $m['won'] }} won</span>
                        </div>
                        <span
                            class="px-2 py-0.5 rounded-full text-xs font-bold {{ $m['rate'] > 20 ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400' : ($m['rate'] > 10 ? 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400' : 'bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-300') }}">
                            {{ $m['rate'] }}%
                        </span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Email Campaign Analytics --}}
        @php $email = $this->getEmailStats(); @endphp
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">✉️ Email Campaign Analytics</h3>
            <div class="grid grid-cols-2 gap-4">
                <div class="text-center p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                    <p class="text-2xl font-bold text-blue-600">{{ $email['campaigns_sent'] }}</p>
                    <p class="text-xs text-gray-500">Campaigns Sent</p>
                </div>
                <div class="text-center p-3 bg-emerald-50 dark:bg-emerald-900/20 rounded-lg">
                    <p class="text-2xl font-bold text-emerald-600">{{ number_format($email['total_sent']) }}</p>
                    <p class="text-xs text-gray-500">Emails Delivered</p>
                </div>
                <div class="text-center p-3 bg-purple-50 dark:bg-purple-900/20 rounded-lg">
                    <p class="text-2xl font-bold text-purple-600">{{ $email['avg_open_rate'] }}%</p>
                    <p class="text-xs text-gray-500">Avg Open Rate</p>
                </div>
                <div class="text-center p-3 bg-orange-50 dark:bg-orange-900/20 rounded-lg">
                    <p class="text-2xl font-bold text-orange-600">{{ $email['avg_click_rate'] }}%</p>
                    <p class="text-xs text-gray-500">Avg Click Rate</p>
                </div>
            </div>
        </div>

        {{-- Social Media Overview --}}
        @php $social = $this->getSocialMediaStats(); @endphp
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">📱 Social Media Overview</h3>
            <div class="grid grid-cols-3 gap-3">
                <div class="text-center p-3 bg-pink-50 dark:bg-pink-900/20 rounded-lg">
                    <p class="text-xl font-bold text-pink-600">{{ number_format($social['total_likes']) }}</p>
                    <p class="text-xs text-gray-500">❤️ Likes</p>
                </div>
                <div class="text-center p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                    <p class="text-xl font-bold text-blue-600">{{ number_format($social['total_comments']) }}</p>
                    <p class="text-xs text-gray-500">💬 Comments</p>
                </div>
                <div class="text-center p-3 bg-green-50 dark:bg-green-900/20 rounded-lg">
                    <p class="text-xl font-bold text-green-600">{{ number_format($social['total_shares']) }}</p>
                    <p class="text-xs text-gray-500">🔄 Shares</p>
                </div>
            </div>
            <div class="mt-4 flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700/30 rounded-lg">
                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-300">
                        {{ number_format($social['total_impressions']) }} impressions</p>
                    <p class="text-xs text-gray-400">{{ $social['total_posts'] }} published posts</p>
                </div>
                <div class="text-right">
                    <p class="text-lg font-bold text-emerald-600">{{ $social['engagement_rate'] }}%</p>
                    <p class="text-xs text-gray-400">Engagement Rate</p>
                </div>
            </div>
        </div>
    </div>
</x-filament-panels::page>