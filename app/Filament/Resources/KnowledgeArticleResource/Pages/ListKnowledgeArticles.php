<?php
namespace App\Filament\Resources\KnowledgeArticleResource\Pages;
use App\Filament\Resources\KnowledgeArticleResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Actions;
class ListKnowledgeArticles extends ListRecords
{
    protected static string $resource = KnowledgeArticleResource::class;
    protected function getHeaderActions(): array
    {
        return [Actions\CreateAction::make()];
    }
}
