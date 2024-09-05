# Bandwidth Notifications Channel for Laravel

[![Latest Version on Packagist](https://img.shields.io/packagist/v/laravel-notification-channels/bandwidth.svg?style=flat-square)](https://packagist.org/packages/laravel-notification-channels/bandwidth)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/laravel-notification-channels/bandwidth/master.svg?style=flat-square)](https://travis-ci.org/laravel-notification-channels/bandwidth)
[![Quality Score](https://img.shields.io/scrutinizer/g/laravel-notification-channels/bandwidth.svg?style=flat-square)](https://scrutinizer-ci.com/g/laravel-notification-channels/bandwidth)
[![Total Downloads](https://img.shields.io/packagist/dt/laravel-notification-channels/bandwidth.svg?style=flat-square)](https://packagist.org/packages/laravel-notification-channels/bandwidth)

This package makes it easy to send notifications using [Bandwidth](https://www.bandwidth.com) with Laravel 10.x.

## Contents

-   [Installation](#installation)
    -   [Setting up the Bandwidth service](#setting-up-the-bandwidth-service)
-   [Usage](#usage)
    -   [Available Message methods](#available-message-methods)
-   [Changelog](#changelog)
-   [Testing](#testing)
-   [Security](#security)
-   [Contributing](#contributing)
-   [Credits](#credits)
-   [License](#license)

## Installation

You can install this package via composer:

```bash
composer require laravel-notification-channels/bandwidth
```

### Setting up the Bandwidth service

To use the Bandwidth service, you need to create an account and obtain the necessary credentials. Follow these steps:

1. Sign up for a Bandwidth account at [https://www.bandwidth.com](https://www.bandwidth.com).
2. Navigate to your Bandwidth dashboard and locate your Account ID, API Username, and API Password.
3. Add the following configuration to your `config/services.php` file:

```php
'bandwidth' => [
    'username' => env('BANDWIDTH_USERNAME'),
    'password' => env('BANDWIDTH_PASSWORD'),
    // 'applicationId' => env('BANDWIDTH_APPLICATION_ID'),
],
```

## Usage

```php
use Illuminate\Notifications\Notification;

class InvoicePaid extends Notification
{
    public function via($notifiable)
    {
        return [BandwidthChannel::class];
    }

    public function toBandwidth($notifiable): array
    {
        return (new BandwidthMessage())
            ->from('+12345678901')
            ->to($notifiable->phone_number)
            ->text('Your invoice has been paid!')
            ->applicationId('your-application-id');
    }
}
```

In your notifiable model, make sure to include the `routeNotificationForBandwidth` method:

```php
class User extends Authenticatable implements Notifiable
{
    use HasFactory, Notifiable;

    public function routeNotificationForBandwidth($notification)
    {
        return $this->phone_number;
    }
}
```

### Available Message methods

-   `from` - The phone number the message should be sent from.
-   `to` - The phone number the message should be sent to.
-   `text` - The message content.
-   `applicationId` - The application ID.

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

```bash
composer test
```

## Security

If you discover any security related issues, please email author email instead of using the issue tracker.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

-   [Bas van Dinther](https://github.com/basvandinther)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
