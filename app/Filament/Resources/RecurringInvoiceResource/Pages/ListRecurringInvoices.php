<?php
namespace App\Filament\Resources\RecurringInvoiceResource\Pages;
use App\Filament\Resources\RecurringInvoiceResource;
use Filament\Resources\Pages\ListRecords;
class ListRecurringInvoices extends ListRecords
{
    protected static string $resource = RecurringInvoiceResource::class;
    protected function getHeaderActions(): array
    {
        return [\Filament\Actions\CreateAction::make()];
    }
}
