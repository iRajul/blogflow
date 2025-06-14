<?php

declare(strict_types=1);

namespace irajul\Blogflow\Enums;

enum Type: string implements \Filament\Support\Contracts\HasLabel
{
    case Post = 'post';
    case Page = 'page';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Post => 'Post',
            self::Page => 'Page',
        };
    }
}
