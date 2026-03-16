<?php

namespace App\Filament\Resources\LandingSectionResource\Pages;

use App\Filament\Resources\LandingSectionResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Pages\CreateRecord\Concerns\Translatable;

class CreateLandingSection extends CreateRecord
{
    use Translatable;

    protected static string $resource = LandingSectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),
        ];
    }
}
