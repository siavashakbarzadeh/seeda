<?php
namespace App\Filament\Resources\TimeEntryResource\Pages;
use App\Filament\Resources\TimeEntryResource;
use Filament\Resources\Pages\EditRecord;
use Filament\Actions;
class EditTimeEntry extends EditRecord
{
    protected static string $resource = TimeEntryResource::class;
    protected function getHeaderActions(): array
    {
        return [Actions\DeleteAction::make()];
    }
}
