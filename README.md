# Quickly send a message to Zoho Cliq Channels.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/marjose123/laravel-zoho-cliq-alert.svg?style=flat-square)](https://packagist.org/packages/marjose123/laravel-zoho-cliq-alert)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/marjose123/laravel-zoho-cliq-alert/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/marjose123/laravel-zoho-cliq-alert/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/marjose123/laravel-zoho-cliq-alert/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/marjose123/laravel-zoho-cliq-alert/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/marjose123/laravel-zoho-cliq-alert.svg?style=flat-square)](https://packagist.org/packages/marjose123/laravel-zoho-cliq-alert)

This package can quickly send alerts to Zoho Cliq. You can use this to notify yourself of any noteworthy events happening in your app.

```Bash
use MarJose123\ZohoCliqAlert\Facades\ZohoCliqAlert;

ZohoCliqAlert::channel('marketing')->message("You have a new subscriber to the {$newsletter->name} newsletter!");
```
Under the hood, a job is used to communicate with Zoho Cliq. This prevents your app from failing in case Zoho Cliq is down.

## Installation

You can install the package via composer:

```bash
composer require marjose123/laravel-zoho-cliq-alert
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="laravel-zoho-cliq-alert-config"
```

This is the contents of the published config file:

```php
return [
];
```


## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [MarJose123](https://github.com/MarJose123)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
