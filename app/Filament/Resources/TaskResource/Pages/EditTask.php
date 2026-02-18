<?php
namespace App\Filament\Resources\TaskResource\Pages;
use App\Filament\Resources\TaskResource;
use Filament\Resources\Pages\EditRecord;
use Filament\Actions;
class EditTask extends EditRecord
{
    protected static string $resource = TaskResource::class;
    protected function getHeaderActions(): array
    {
        return [Actions\DeleteAction::make()];
    }
}
