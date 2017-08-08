# Laravauth

Laravel authentication with a twist.

## Synopsis

This package works by hooking. How? Simply hooks to the `login` route and continues work from there.

## Installation

The installation process of this package is a breeze. The first step is to rqquire with comoposer.

```
composer require paschaldev/laravauth
```

Next, open `conig/app.php` in your laravel installation directory and add this line in the `providers` array.

```
PaschalDev\Laravauth\Providers\LaravauthServiceProvider::class,
```

That's all there is to do. Installation complete.

## Usage