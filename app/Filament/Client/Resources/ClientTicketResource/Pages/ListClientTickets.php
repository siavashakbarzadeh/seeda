<?php
namespace App\Filament\Client\Resources\ClientTicketResource\Pages;
use App\Filament\Client\Resources\ClientTicketResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions;
class ListClientTickets extends ListRecords
{
    protected static string $resource = ClientTicketResource::class;
    protected function getHeaderActions(): array
    {
        return [Actions\CreateAction::make()->label('New Ticket')];
    }
}
