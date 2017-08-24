# Laravauth

> Laravel authentication with a twist.

**Laravauth** is an authentication package for laravel that uses a different technique other than the traditional authentication methods.

## Synopsis

This package works by hooking. How? Simply hooks to the `login` route, intercepts it and continues work from there.

The first step to hooking is from your route, the default route is a post request to `login`, once there is a request to that route, the plugin comes alive. The following modes of authorization are available:

1. Email Token 
2. Two Factor Authorization (SMS)

##### Email Token 

This type of authorization does not require passwords. The user simply provides his email address (must have been a registered user), if the email is present in the database, a temporary login link containing a secure token is sent to the user's email address. This login link is only valid for a specific amount of time, the default is 10minutes after which the link becomes invalid and the user will have to make a new login request.

##### Two Factor Authorization (SMS)

Two Factor Authorization is an extra layer of security that ensures the user has another "thing they have" to couple with the "thing they know". The "thing they know" is usually their password, the "thing they have" for this case is a personal mobile number a token is sent to. [Read more](https://www.google.com.ng/url?sa=t&rct=j&q=&esrc=s&source=web&cd=4&cad=rja&uact=8&ved=0ahUKEwiZpdqFy8nVAhXCL1AKHR9HAboQFghMMAM&url=https%3A%2F%2Fen.wikipedia.org%2Fwiki%2FMulti-factor_authentication&usg=AFQjCNG5ZrSt445-9PIhTFVh7goI4j6Jbw "Wikipedia - Multi-factor authorization")

This mode of authorization requires password and a phone number for the user. After the user provides his login credentials, default is `email` and `password`, **Laravauth** serves a page requesting a token, a short lived token valid for a specific amount of time (default is 10minutes) is sent to the user's phone. The user provides the token, if it's valid, the user is authenticated.


## Installation

The installation process of this package is a breeze. The first step is to require with comoposer.

```
$ composer require paschaldev/laravauth
```

Open `app.php` in your config directory of your laravel installation and add this line in the `providers` array.

```
PaschalDev\Laravauth\Providers\LaravauthServiceProvider::class,
```

You will need to publish the configuration and view files.

```
$ php artisan vendor:publish --provider="PaschalDev\Laravauth\Providers\LaravauthServiceProvider"
```

**Laravauth** alters the user's table and adds extra columns it uses for authentication. Next step is to migrate the database.

> Make sure your database has been setup and working fine before proceeding.

The default configuration assumes the user's model is `App\Users`, if this is not so in your application, please skip this step, update your laravauth configuration to reflect this change before running the command below.

Now run:

```
$ php artisan migrate
```

If all is good, migration is succesfull. That's all there is to do. Installation complete.

## Usage

**Laravauth** does not ship with a `login` view, you can use your present `login` view and just make slight changes.

Depending on the mode you choose, there are different ways to make things work. The configuration file has everything you'll need to tweak the package so that it plugs in perfectly to your application.

**Laravauth** requires little or no alteration of your previous application code, everything works seamlessly from start to finish. You don't need to bend your codes at all, all you need to is make sure to key in the right configuration values in your **laravauth** config file `laravauth.php` in the config directory after you must have published.

#### Email Token 

This is the default mode. All that is required in this mode is an input in the login view that contains the user's email. Like below: 

```
<input type="email" name="email" />
```

**Laravauth** uses `email` as the default. If your login view has a name that is not `email`, say for example:

```
<input type="email" name="user_email" />
```

You'll need to update your **Laravauth** configuration file to match this, open the config file `laravauth.php` and change the config `login_id` to `user_email` and you're good to go.

**Laravauth** also assumes the email column on the user's table is named `email`, if it is anything other than that, change the config `login_id_rel` to match the name of the email column on the user's table.

P.S: Very important, make sure your app `url` in laravel's `app.php` config file is set to the correct value else the package might generate invalid links.

#### Two Factor Authorization (SMS)

This mode of authorization requires an SMS provider. Two providers are shipped with this package:

1. [Nexmo](http://nexmo.com)
2. [Twilio](http://twilio.com)

You can choose your preferred provider by changing the value in the `laravauth` config file. Look for the option `two_factor_sms`, its an array that contains specific configuration for the two factor sms mode. Inside the array is a `gateway` option you can toggle. Possible values are `nexmo` and `twilio`. 

Each of these providers have their own specific requirements. You are required to register with any provider of your choice. 

PS: Using this option, you know you should have a large amount of balance to be able to accomodate the frequnt logins. 

##### Nexmo 

Nexmo requires the following to be added and set in your `.env` file:

```
NEXMO_KEY=xxxxxx
NEXMO_SECRET=xxxxxx
NEXMO_FROM=xxxxxx
```

You can get your nexmo key and secret from your dashboard after creating account.

##### Twilio 

Twilio requires the following to be added in your `.env` file:

```
TWILIO_SID=xxxxxx
TWILIO_TOKEN=xxxxx
TWILIO_FROM=xxxxx
```

You can get all the values from your twilio dashboard. The `TWILIO_FROM` is a phone number you get when you are done creating account. This is where your SMS will originate from.

___

After setting the SMS providers, you are one step there. Now you need to tell **Laravauth** how to retrieve a user's phone number by adding the following method to your user model: `laravauthPhone()`.

```php
class User extends Authenticatable
{
    use Notifiable;

    .
    .
    .

    laravauthPhone(){

    	//The logic to retrieve user's phone number.
    }
}

```


Next thing is the view that validates the token. In this mode, it requires the user logs in with `email` and `password` by default. If your login is not like this, maybe you use `username` and `password`, no problem, just update your configuration file and set the `login_id` and `login_id_rel` to the correct value. 

These two options are required to be passed from your `login` view, a corresponding `email` or whatever the case may be and `password`. Also, if your password uses another name other than `password`, make sure to update the `password_id` in the configuration and also the `password_id_rel` if the password column on the user's table in the database uses another name other than 'password'.

Once a user logs in and the credentials are valid, a page asking for the token is served. **Laravauth** ships with a sample working page. The major thing is the markup seen below:

```html
<form method="POST" action="{{ url('/validate') }}">
	<input type="text" name="{{ laravauth_token_var_name() }}" />
	<button type="submit">Submit</button>
	{{ csrf_field() }}
</form>
```

**Laravauth** uses a different route for validating authentication, which can be customized in your config file, look for `validator_route` and adjust to suit your needs. The default is `'validate'`. The form's action attribute should point to the validator route, the method should also be `POST`.

The other thing required is a `token` input. This should not be confused with Laravel's own `_token` for protecting against CSRF (Cross-Site Request Forgery). You can change the name of the `token` variable used by **Laravauth** by updating the `token_var` option in the config file, the default is `'token'`. **Laravauth** has an helper method to output this variable name `laravauth_token_var_name()` so you don't need bother much, just output the function in the `name` attribute of the input that will be sent to the `validator` route.

Once the form is submitted, the `validator` confirms if it's a valid token, if not the page is re-served. If it's valid, the user is authenticated and redirected to the auth page you define.

# Configuration

**Laravauth** comes with a handful of configuration, you can check the `laravauth` config file for all available options, they are documented so it should be easy to see what they do.

One notable option is `soft_disable`. If you will like to disable **Laravauth** temporarily without removing the package, just set this value to `true` and **Laravauth** goes to sleep mode, it doesnt intercept your login.

Another very important option is the `user_model` option. This should point to the model that access your user table. The default is `App\User` which is Laravel's default.

For more options, check the configuration file.
