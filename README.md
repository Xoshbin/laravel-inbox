# Laravel Inbox
Receive and send emails from your project with Laravel

Inbox extends [beyondcode/laravel-mailbox](https://github.com/beyondcode/laravel-mailbox)

![Image of Inbox](https://github.com/Xoshbin/laravel-inbox/blob/master/Screen-Shot.png?raw=true)

## Installation

You can install the package via composer:

```bash
composer require xoshbin/inbox
```
After installing Inbox, publish its assets using the inbox:install Artisan command:

```bash
php artisan inbox:install
```

This package extends the migration file of beyondcode/laravel-mailbox to store all incoming email messages. You can publish the migration file using:

```bash
php artisan vendor:publish --provider="Xoshbin\Inbox\InboxServiceProvider" --tag="migrations"
```

Run the migrations with:

```bash
php artisan migrate
```

Next, you need to publish the inbox configuration file which it's the same file of beyondcode/laravel-mailbox with some extra variables:

```bash
php artisan vendor:publish --provider="Xoshbin\Inbox\InboxServiceProvider" --tag="config"

```
## Connecting email drivers

To connect your email provider with this package you have to follow [beyondcode/laravel-mailbox](https://docs.beyondco.de/laravel-mailbox) documentation.

## Usage

After connecting your email provider you can visit the inbox interface from url **/inbox/dashboard** like that: <br>
**example.com/inbox/dashboard**


### TO-DO
- [x] Changing views to vue components.
- [x] Saving sent emails.
- [ ] Adding tests.

### Bootstrap Template
special thanks to [Bootstrap snippet. bs4 beta email inbox](https://www.bootdey.com/snippets/view/bs4-beta-email-inbox)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
