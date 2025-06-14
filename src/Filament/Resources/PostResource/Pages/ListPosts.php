<?php

namespace irajul\Blogflow\Filament\Resources\PostResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use irajul\Blogflow\Filament\Resources\PostResource;

class ListPosts extends ListRecords
{
    protected static string $resource = PostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
