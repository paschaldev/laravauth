# Laravauth

Laravel authentication with a twist.

## Synopsis

This package works by hooking. How? Simply hooks to the `login` route and continues work from there.

## Installation

The installation process of this package is a breeze. The first step is to require with comoposer.

```
$ composer require paschaldev/laravauth
```

Open `app.php` in your config directory of your laravel installation and add this line in the `providers` array.

```
PaschalDev\Laravauth\Providers\LaravauthServiceProvider::class,
```

**Laravauth** alters the user's table and adds extra columns it uses for authentication. Next step is to migrate the database.

> Make sure your database has been setup and working fine before proceeding.

The default configuration assumes the user's table name is `users`, if this is not so in your application, please skip this step, update your laravauth configuration to reflect this change before running the command below.

Now run:

```
$ php artisan migrate
```

If all is good, migration is succesfull. Finally, you can publish the configuration and view files.

```
$ php artisan vendor:publish --provider="PaschalDev\Laravauth\Providers\LaravauthServiceProvider"
```

That's all there is to do. Installation complete.

## Usage