<?php

declare(strict_types=1);

namespace irajul\Blogflow\Enums;

enum Status: string implements \Filament\Support\Contracts\HasLabel
{
    case Draft = 'draft';
    case Published = 'published';
    case Scheduled = 'scheduled';

    public function getLabel(): string
    {
        return match ($this) {
            self::Draft => 'Draft',
            self::Published => 'Published',
            self::Scheduled => 'Scheduled',
        };
    }
}
