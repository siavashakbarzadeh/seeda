<?php
namespace App\Filament\Resources\RoleResource\Pages;
use App\Filament\Resources\RoleResource;
use Filament\Resources\Pages\EditRecord;
use Filament\Actions;
class EditRole extends EditRecord
{
    protected static string $resource = RoleResource::class;
    protected function getHeaderActions(): array
    {
        return [Actions\DeleteAction::make()];
    }
}
