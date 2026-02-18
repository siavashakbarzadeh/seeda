<?php
namespace App\Filament\Resources\TimeEntryResource\Pages;
use App\Filament\Resources\TimeEntryResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions;
class ListTimeEntries extends ListRecords
{
    protected static string $resource = TimeEntryResource::class;
    protected function getHeaderActions(): array
    {
        return [Actions\CreateAction::make()->label('Log Time')];
    }
}
