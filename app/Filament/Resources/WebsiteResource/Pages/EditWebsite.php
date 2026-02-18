<?php
namespace App\Filament\Resources\WebsiteResource\Pages;
use App\Filament\Resources\WebsiteResource;
use Filament\Resources\Pages\EditRecord;
use Filament\Actions;
class EditWebsite extends EditRecord
{
    protected static string $resource = WebsiteResource::class;
    protected function getHeaderActions(): array
    {
        return [Actions\DeleteAction::make()];
    }
}
