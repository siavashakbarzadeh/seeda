<?php
namespace App\Filament\Resources\ContractResource\Pages;
use App\Filament\Resources\ContractResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions;
class ListContracts extends ListRecords
{
    protected static string $resource = ContractResource::class;
    protected function getHeaderActions(): array
    {
        return [Actions\CreateAction::make()];
    }
}
