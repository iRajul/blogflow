# laravel filament plugin for markdown blog support in panel.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/irajul/blogflow.svg?style=flat-square)](https://packagist.org/packages/irajul/blogflow)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/irajul/blogflow/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/irajul/blogflow/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/irajul/blogflow/fix-php-code-styling.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/irajul/blogflow/actions?query=workflow%3A"Fix+PHP+code+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/irajul/blogflow.svg?style=flat-square)](https://packagist.org/packages/irajul/blogflow)

![blogflow](https://github.com/user-attachments/assets/241e0749-019f-42b9-94d2-494c6974b835)

This is where your description should go. Limit it to a paragraph or two. Consider adding a small example.

## Installation

You can install the package via composer:

```bash
composer require irajul/blogflow
```

If you haven't already done so, you need to publish the migration to create the tags table:

php artisan vendor:publish --provider="Spatie\Tags\TagsServiceProvider" --tag="tags-migrations"

For more information, check out [Spatie's documentation](https://spatie.be/docs/laravel-tags).

php artisan vendor:publish --provider="Spatie\MediaLibrary\MediaLibraryServiceProvider" --tag="medialibrary-migrations"

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

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="blogflow-views"
```

This is the contents of the published config file:

```php
return [
];
```

## Usage


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
