<x-filament-panels::page>
    @php
        $lead = $this->record;
        $statusColors = [
            'new' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400',
            'contacted' => 'bg-indigo-100 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-400',
            'qualified' => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400',
            'proposal' => 'bg-orange-100 text-orange-700 dark:bg-orange-900/30 dark:text-orange-400',
            'negotiation' => 'bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-400',
            'won' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400',
            'lost' => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400',
        ];
    @endphp

    {{-- Profile Card --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700 mb-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="flex items-center gap-4">
                <div
                    class="w-14 h-14 rounded-full bg-gradient-to-br from-emerald-400 to-emerald-600 flex items-center justify-center text-white text-xl font-bold">
                    {{ strtoupper(substr($lead->name, 0, 1)) }}
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">{{ $lead->name }}</h2>
                    <p class="text-sm text-gray-500">
                        {{ $lead->company ?? 'No company' }}
                        @if($lead->industry) ·
                        {{ \App\Models\Lead::getIndustryOptions()[$lead->industry] ?? $lead->industry }} @endif
                    </p>
                    <p class="text-xs text-gray-400 mt-0.5">Added {{ $this->getLeadAge() }}</p>
                </div>
            </div>
            <div class="flex items-center gap-3 flex-wrap">
                <span class="px-3 py-1 rounded-full text-xs font-bold {{ $statusColors[$lead->status] ?? '' }}">
                    {{ \App\Models\Lead::getStatusOptions()[$lead->status] ?? $lead->status }}
                </span>
                @if($lead->score >= 50)
                    <span
                        class="px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400">🔥
                        Hot Lead</span>
                @endif
                <a href="/admin/leads/{{ $lead->id }}/edit"
                    class="px-3 py-1.5 rounded-lg bg-emerald-600 text-white text-xs font-medium hover:bg-emerald-700 transition">
                    ✏️ Edit Lead
                </a>
            </div>
        </div>
    </div>

    {{-- Pipeline Progress --}}
    @php
        $stages = ['new', 'contacted', 'qualified', 'proposal', 'negotiation', 'won'];
        $currentIndex = array_search($lead->status, $stages);
        if ($currentIndex === false)
            $currentIndex = -1;
    @endphp
    <div class="bg-white dark:bg-gray-800 rounded-xl p-4 shadow-sm border border-gray-200 dark:border-gray-700 mb-6">
        <div class="flex items-center gap-1">
            @foreach($stages as $i => $stage)
                <div class="flex-1 text-center">
                    <div
                        class="h-2 rounded-full {{ $i <= $currentIndex ? 'bg-emerald-500' : 'bg-gray-200 dark:bg-gray-700' }} transition-all">
                    </div>
                    <p
                        class="text-[10px] mt-1 {{ $i <= $currentIndex ? 'text-emerald-600 font-semibold' : 'text-gray-400' }}">
                        {{ ucfirst($stage) }}
                    </p>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Details Grid --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <div
            class="bg-white dark:bg-gray-800 rounded-xl p-4 shadow-sm border border-gray-200 dark:border-gray-700 text-center">
            <p class="text-sm text-gray-500 mb-1">Estimated Value</p>
            <p class="text-xl font-bold text-emerald-600">€{{ number_format($lead->estimated_value ?? 0, 0) }}</p>
        </div>
        <div
            class="bg-white dark:bg-gray-800 rounded-xl p-4 shadow-sm border border-gray-200 dark:border-gray-700 text-center">
            <p class="text-sm text-gray-500 mb-1">Score</p>
            <p
                class="text-xl font-bold {{ $lead->score >= 50 ? 'text-emerald-600' : ($lead->score >= 30 ? 'text-yellow-600' : 'text-gray-500') }}">
                {{ $lead->score }}</p>
        </div>
        <div
            class="bg-white dark:bg-gray-800 rounded-xl p-4 shadow-sm border border-gray-200 dark:border-gray-700 text-center">
            <p class="text-sm text-gray-500 mb-1">Source</p>
            <p class="text-sm font-semibold text-gray-900 dark:text-white">
                {{ \App\Models\Lead::getSourceOptions()[$lead->source] ?? $lead->source }}</p>
        </div>
        <div
            class="bg-white dark:bg-gray-800 rounded-xl p-4 shadow-sm border border-gray-200 dark:border-gray-700 text-center">
            <p class="text-sm text-gray-500 mb-1">Assigned To</p>
            <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $lead->assignedUser?->name ?? '—' }}</p>
        </div>
    </div>

    {{-- Contact Info --}}
    <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700 mb-6">
        <h3 class="text-md font-semibold text-gray-900 dark:text-white mb-3">📇 Contact Info</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
            <div>
                <span class="text-gray-400">Email</span>
                <p class="text-gray-900 dark:text-white font-medium">{{ $lead->email ?? '—' }}</p>
            </div>
            <div>
                <span class="text-gray-400">Phone</span>
                <p class="text-gray-900 dark:text-white font-medium">{{ $lead->phone ?? '—' }}</p>
            </div>
            <div>
                <span class="text-gray-400">Website</span>
                <p class="text-gray-900 dark:text-white font-medium">{{ $lead->website ?? '—' }}</p>
            </div>
            <div>
                <span class="text-gray-400">Campaign</span>
                <p class="text-gray-900 dark:text-white font-medium">{{ $lead->campaign?->name ?? '—' }}</p>
            </div>
        </div>
        @if($lead->notes)
            <div class="mt-4 p-3 bg-gray-50 dark:bg-gray-700/30 rounded-lg">
                <p class="text-xs text-gray-400 mb-1">Notes</p>
                <p class="text-sm text-gray-700 dark:text-gray-300 whitespace-pre-line">{{ $lead->notes }}</p>
            </div>
        @endif
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Activity Timeline --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
            <h3 class="text-md font-semibold text-gray-900 dark:text-white mb-4">📋 Activity Timeline</h3>
            <div class="space-y-4 relative">
                <div class="absolute left-3 top-0 bottom-0 w-px bg-gray-200 dark:bg-gray-700"></div>
                @forelse($this->getActivities() as $activity)
                    <div class="flex gap-3 relative pl-6">
                        <div
                            class="absolute left-1.5 w-3 h-3 rounded-full {{ $activity->is_completed ? 'bg-emerald-500' : 'bg-gray-300 dark:bg-gray-600' }} ring-2 ring-white dark:ring-gray-800">
                        </div>
                        <div class="flex-1 pb-3">
                            <div class="flex items-center justify-between">
                                <span
                                    class="text-xs px-2 py-0.5 rounded-full font-medium bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300">
                                    {{ \App\Models\LeadActivity::getTypeOptions()[$activity->type] ?? $activity->type }}
                                </span>
                                <span class="text-xs text-gray-400">{{ $activity->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-sm text-gray-700 dark:text-gray-300 mt-1">{{ $activity->description }}</p>
                            <p class="text-xs text-gray-400 mt-0.5">by {{ $activity->user?->name ?? 'System' }}</p>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-400 text-sm pl-6">No activities yet.</p>
                @endforelse
            </div>
        </div>

        {{-- Behavioral Interactions --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl p-6 shadow-sm border border-gray-200 dark:border-gray-700">
            <h3 class="text-md font-semibold text-gray-900 dark:text-white mb-4">🖱️ Behavioral Interactions</h3>
            <div class="space-y-3">
                @forelse($this->getInteractions() as $interaction)
                    <div
                        class="flex items-center justify-between py-2 border-b border-gray-100 dark:border-gray-700 last:border-0">
                        <div>
                            <span
                                class="text-xs px-2 py-0.5 rounded-full font-medium bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400">
                                {{ $interaction->action }}
                            </span>
                            <p class="text-xs text-gray-500 mt-0.5 font-mono">{{ Str::limit($interaction->url, 40) }}</p>
                        </div>
                        <div class="text-right">
                            <span class="text-xs font-semibold text-emerald-600">+{{ $interaction->points }}</span>
                            <p class="text-xs text-gray-400">{{ $interaction->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-400 text-sm">No tracked interactions.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-filament-panels::page>