<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Application Login Route
    |--------------------------------------------------------------------------
    |
    | This is the login route used by your application. It is usually a post
    | request with the forwarded data to this route that handles the login.
    |
    | @required String
    */

    'login_route' => 'login',

    /*
    |--------------------------------------------------------------------------
    | Laravauth Validator Route
    |--------------------------------------------------------------------------
    |
    | This is the login route used by your application. It is usually a post
    | request with the forwarded data to this route that handles the login.
    |
    | @required String
    */

    'validator_route' => 'validate',

    /*
    |--------------------------------------------------------------------------
    | Login Unique Identifier
    |--------------------------------------------------------------------------
    |
    | Depending on how your application is structured, every user should have a
    | unique ID for authentication. This value can be username, email, phone or 
    | whatsoever and should match the input name passed in the login form view.
    |
    | This is basically the name of the input from the the login view form.
    |
    | @required string
    */

    'login_id' => 'email',

    /*
    |--------------------------------------------------------------------------
    | Login Identifier Relationship
    |--------------------------------------------------------------------------
    |
    | Database column name relating the Login Identifier from the view and
    | the Relationship in the User database. Default is email.
    |
    | @required string
    */

    'login_id_rel' => 'email',

    /*
    |--------------------------------------------------------------------------
    | Login Unique Identifier
    |--------------------------------------------------------------------------
    |
    | This is the name of the input tag that will contain password from the the 
    | login view form. 
    | 
    | PS: If you are using auth_methods that require passwords e.g 
    | two_factor_sms make sure this value corresponds.
    |
    | @required string
    */

    'password_id' => 'password',

    /*
    |--------------------------------------------------------------------------
    | Password Relationship
    |--------------------------------------------------------------------------
    |
    | Database column name relating the user password from the view and
    | the Relationship in the User database. Default is password.
    | 
    | PS: If you are using auth_methods that require passwords e.g 
    | two_factor_sms make sure this value corresponds.
    |
    | @required string
    */

    'password_rel' => 'password',

    /*
    |--------------------------------------------------------------------------
    | User Model
    |--------------------------------------------------------------------------
    |
    | The User model of your application. This model is used to retrieve the 
    | unique user information from the login unique identifier provided.
    |
    | @required String
    */

    'user_model' => 'App\User',

    /*
    |--------------------------------------------------------------------------
    | Authentication Methods
    |--------------------------------------------------------------------------
    |
    | The authentication method to use.  
    |
    | Possible Values: 'email_token', 'two_factor_sms'
    |
    | @required string
    */

    'auth_method' => 'email_token',

    /*
    |--------------------------------------------------------------------------
    | Token Variable
    |--------------------------------------------------------------------------
    |
    | The name of the token variable used in view forms and URL generator.  
    |
    | @required string
    */

    'token_var' => 'token',

    /*
    |--------------------------------------------------------------------------
    | Soft Disable
    |--------------------------------------------------------------------------
    |
    | It is easy to swicth the availability of this package by simply toggling
    | this value. The default value is false. If set to true, none
    | of the routes are executed thereby soft disabling the package.
    |
    | @optional bool
    */

    'soft_disable' => false,

    /*
    |--------------------------------------------------------------------------
    | DATABASE: Auth Plus Token Column
    |--------------------------------------------------------------------------
    |
    | The name of the column to be created and used for storing tokens for auth
    | methods that require tokens on the users table.
    |
    | @required string
    */

    'token_column_name' => 'laravauth_token',

    /*
    |--------------------------------------------------------------------------
    | DATABASE: Auth Plus Token Type column name
    |--------------------------------------------------------------------------
    |
    | The name of the column to be created and used for storing token types for 
    | auth methods that require tokens on the users table.
    |
    | @required string
    */

    'token_type_column_name' => 'laravauth_token_type',

    /*
    |--------------------------------------------------------------------------
    | Email Token Auth Method specific configuration
    |--------------------------------------------------------------------------
    |
    | Specific confguarion for email_token auth method.
    |
    | @required array
    */

    'email_token' => [

        //Token lifetime in seconds
        'lifetime' => 600,

        //Length of the random string to be hashed
        'length' => 50,

        //See full list of options here http://php.net/manual/en/function.hash-algos.php
        'algorithm' => 'sha256',

        //Subject of the mail
        'mail_subject' => 'Login to %appname%'
    ],

    /*
    |--------------------------------------------------------------------------
    | Two Factor (SMS) Auth Method specific configuration
    |--------------------------------------------------------------------------
    |
    | Specific confguarion for two_factor_sms auth method.
    |
    | @required array
    */

    'two_factor_sms' => [

        //Token lifetime in seconds
        'lifetime' => 600,

        //Length of the token
        'length' => 10,

        //Text to append before the token code
        'text_prefix' => 'Your one time password (OTP) valid for %validity%min is: ',

        //Support for 3 gateways / sms providers.
        //Possible values: nexmo, twilio, messagebird
        'gateway' => 'nexmo'
    ],

    /*
    |--------------------------------------------------------------------------
    | Auth Redirect
    |--------------------------------------------------------------------------
    |
    | After a successful authentication, the user will be redirected to the 
    | value provided below. This is the equivalent to $redirectTo property in 
    | the default LoginController.
    |
    | @required string
    */

    'auth_redirect' => '/home',
];
