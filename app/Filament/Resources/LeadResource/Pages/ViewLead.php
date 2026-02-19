<?php

namespace App\Filament\Resources\LeadResource\Pages;

use App\Models\Lead;
use App\Models\LeadActivity;
use App\Models\LeadInteraction;
use Filament\Resources\Pages\Page;
use App\Filament\Resources\LeadResource;

class ViewLead extends Page
{
    protected static string $resource = LeadResource::class;
    protected static string $view = 'filament.resources.lead-resource.pages.view-lead';

    public Lead $record;

    public function mount(int|string $record): void
    {
        $this->record = Lead::with(['assignedUser', 'campaign', 'client'])->findOrFail($record);
    }

    public function getTitle(): string
    {
        return $this->record->name;
    }

    public function getActivities(): \Illuminate\Support\Collection
    {
        return LeadActivity::where('lead_id', $this->record->id)
            ->with('user')
            ->orderByDesc('created_at')
            ->take(20)
            ->get();
    }

    public function getInteractions(): \Illuminate\Support\Collection
    {
        return LeadInteraction::where('lead_id', $this->record->id)
            ->orderByDesc('created_at')
            ->take(15)
            ->get();
    }

    public function getLeadAge(): string
    {
        return $this->record->created_at->diffForHumans();
    }
}
