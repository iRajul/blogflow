<?php

namespace irajul\Blogflow\Filament\Resources\PostResource\Pages;

use Filament\Resources\Pages\CreateRecord;
use irajul\Blogflow\Filament\Resources\PostResource;

class CreatePost extends CreateRecord
{
    protected static string $resource = PostResource::class;
}
