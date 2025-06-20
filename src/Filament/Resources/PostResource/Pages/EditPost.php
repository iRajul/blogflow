<?php

namespace irajul\Blogflow\Filament\Resources\PostResource\Pages;

use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;
use irajul\Blogflow\Filament\Resources\PostResource;
use irajul\Blogflow\Models\Post;

class EditPost extends EditRecord
{
    protected static string $resource = PostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Action::make('view')
            //     ->label('View')
            //     ->url(fn (Post $record) => route($record->route_name, $record->slug))
            //     ->icon('heroicon-o-eye')
            //     ->openUrlInNewTab(),
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
