<?php
namespace App\Filament\Resources\MarketingFunnelResource\Pages;
use App\Filament\Resources\MarketingFunnelResource;
use Filament\Resources\Pages\ListRecords;
class ListMarketingFunnels extends ListRecords
{
    protected static string $resource = MarketingFunnelResource::class;
    protected function getHeaderActions(): array
    {
        return [\Filament\Actions\CreateAction::make()];
    }
}
