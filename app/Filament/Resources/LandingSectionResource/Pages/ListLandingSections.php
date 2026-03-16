<?php

namespace App\Filament\Resources\LandingSectionResource\Pages;

use App\Filament\Resources\LandingSectionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Pages\ListRecords\Concerns\Translatable;

class ListLandingSections extends ListRecords
{
    use Translatable;

    protected static string $resource = LandingSectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),
            Actions\CreateAction::make(),
        ];
    }
}
