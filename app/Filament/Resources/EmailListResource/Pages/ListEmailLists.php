<?php
namespace App\Filament\Resources\EmailListResource\Pages;
use App\Filament\Resources\EmailListResource;
use Filament\Resources\Pages\ListRecords;
class ListEmailLists extends ListRecords
{
    protected static string $resource = EmailListResource::class;
    protected function getHeaderActions(): array
    {
        return [\Filament\Actions\CreateAction::make()];
    }
}
