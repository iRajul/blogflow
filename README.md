# Laravel Filament plugin for markdown blog support in panel.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/irajul/blogflow.svg?style=flat-square)](https://packagist.org/packages/irajul/blogflow)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/irajul/blogflow/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/irajul/blogflow/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/irajul/blogflow/fix-php-code-styling.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/irajul/blogflow/actions?query=workflow%3A"Fix+PHP+code+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/irajul/blogflow.svg?style=flat-square)](https://packagist.org/packages/irajul/blogflow)

![blogflow](https://github.com/user-attachments/assets/241e0749-019f-42b9-94d2-494c6974b835)


This is opioniated laravel filament panel plugin to add markdown blog support. This is only backend plugin. 
As people can use any frontend framework to create frontend for blogflow.

It requires few pre requisites packages to work, so make sure they are available in your project.

## Installation

You can install the package via composer:

```bash
composer require irajul/blogflow
```

If you haven't already done so, you need to publish the migration to create the tags table:

```bash
php artisan vendor:publish --provider="Spatie\Tags\TagsServiceProvider" --tag="tags-migrations"
```

For more information, check out [Spatie's documentation](https://spatie.be/docs/laravel-tags).

```bash
php artisan vendor:publish --provider="Spatie\MediaLibrary\MediaLibraryServiceProvider" --tag="medialibrary-migrations"
```

You must also [prepare your Eloquent model](https://spatie.be/docs/laravel-medialibrary/basic-usage/preparing-your-model) for attaching media.

For more information, check out [Spatie's documentation](https://spatie.be/docs/laravel-medialibrary).

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="blogflow-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="blogflow-config"
```

## Use Blog in Filament Panel

```
use irajul\Blogflow\Blogflow;

public function panel(Panel $panel): Panel
{
    return $panel
        ->plugins([
            Blogflow::make()
        ])
}
```

## Manage User Relationship
Please ensure user model has relationshio with `Post` Model.
```
<?php

namespace App\Models;

use irajul\Blogflow\Traits\HasBlog;
use Illuminate\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasBlog;
}
```

## Config

This package needs few config to work. make sure to set disk as per your preference. 
If you use S3/R2 then make sure their permission has public read access.
```php
return [
    'tables' => [
        'prefix' => 'blogflow_', // prefix for all blog tables
    ],
    'user' => [
        'model' => \App\Models\User::class,
        'foreign_key' => 'user_id',
        'columns' => [
            'name' => 'name',
        ],
    ],
    'featured_image' => [
        'thumbnail' => [
            'width' => 300,
            'height' => 300,
        ],
        'fallback_url' => 'https://images.unsplash.com/photo-1547586696-ea22b4d4235d?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=3270&q=80',
        'collection_name' => 'post_feature_image',
    ],
    'disk' => 'public',
];
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Rajul](https://github.com/iRajul)
- [All Contributors](../../contributors)

## Sponsor

- [NextSprints](https://nextsprints.com)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
