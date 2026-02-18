<?php
namespace App\Filament\Resources\TicketResource\Pages;
use App\Filament\Resources\TicketResource;
use Filament\Resources\Pages\EditRecord;
use Filament\Actions;
class EditTicket extends EditRecord
{
    protected static string $resource = TicketResource::class;
    protected function getHeaderActions(): array
    {
        return [Actions\ViewAction::make(), Actions\DeleteAction::make()];
    }
}
