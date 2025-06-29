<?php

namespace irajul\Blogflow;

use Filament\Contracts\Plugin;
use Filament\Panel;
use irajul\Blogflow\Filament\Resources\PostResource;

class Blogflow implements Plugin
{
    public function getId(): string
    {
        return 'blogflow';
    }

    public function register(Panel $panel): void
    {
        $panel->resources(
            [
                PostResource::class,
            ]
        );
    }

    public function boot(Panel $panel): void
    {
        //
    }

    public static function make(): static
    {
        return app(static::class);
    }

    public static function get(): static
    {
        /** @var static $plugin */
        $plugin = filament(app(static::class)->getId());

        return $plugin;
    }
}
