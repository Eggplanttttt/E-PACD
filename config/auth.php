<?php

return [

    /*
    |---------------------------------------------------------------------------
    | Authentication Defaults
    |---------------------------------------------------------------------------
    |
    | This option controls the default authentication "guard" and password
    | reset options for your application. You may change these defaults
    | as required, but they're a perfect start for most applications.
    |
    */

    'defaults' => [
        'guard' => 'web',
        'passwords' => 'users',
    ],

    /*
    |---------------------------------------------------------------------------
    | Authentication Guards
    |---------------------------------------------------------------------------
    |
    | Here you may define every authentication guard for your application.
    | Each guard defines a way of authenticating a user, whether that be using
    | a session, API token, etc. We have a default "session" guard setup, 
    | which uses session storage for authenticating the user.
    |
    | Supported: "session", "token"
    |
    */

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],

        'admin' => [
            'driver' => 'session',
            'provider' => 'admins',
        ],

        'student' => [
            'driver' => 'session',
            'provider' => 'students',
        ],

        'faculty' => [
            'driver' => 'session',
            'provider' => 'faculties',
        ],

        'alumni' => [
            'driver' => 'session',
            'provider' => 'alumnis',
        ],

        'others' => [
            'driver' => 'session',
            'provider' => 'others',
        ],
    ],

    /*
    |---------------------------------------------------------------------------
    | User Providers
    |---------------------------------------------------------------------------
    |
    | The user provider defines how users are retrieved out of your database or 
    | other storage mechanisms used by this application to persist your user's data.
    | Each guard is tied to a specific user provider that defines how the users 
    | are retrieved.
    |
    | Supported: "database", "eloquent"
    |
    */

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class, // Default User model
        ],

        'admins' => [
            'driver' => 'eloquent',
            'model' => App\Models\AdminAccount::class, // Admin Account model
        ],

        'students' => [
            'driver' => 'eloquent',
            'model' => App\Models\Student::class, // Student model
        ],

        'faculties' => [
            'driver' => 'eloquent',
            'model' => App\Models\Faculty::class, // Faculty model
        ],

        'alumnis' => [
            'driver' => 'eloquent',
            'model' => App\Models\Alumni::class, // Alumni model
        ],

        'others' => [
            'driver' => 'eloquent',
            'model' => App\Models\Other::class, // Other users model
        ],
    ],

    /*
    |---------------------------------------------------------------------------
    | Resetting Passwords
    |---------------------------------------------------------------------------
    |
    | You may specify multiple password reset configurations if you have more
    | than one user table or model in the application. This is helpful when
    | different user types (e.g. Admin, Student, Faculty) need separate reset
    | settings based on their respective models.
    |
    */

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_reset_tokens', // Password reset table
            'expire' => 60, // Token expiration in minutes
            'throttle' => 60, // Throttle time in seconds
        ],
    ],

    /*
    |---------------------------------------------------------------------------
    | Password Confirmation Timeout
    |---------------------------------------------------------------------------
    |
    | Here you may define the amount of seconds before a password confirmation
    | times out, requiring the user to re-enter their password.
    |
    | By default, the timeout lasts for three hours.
    |
    */

    'password_timeout' => 10800, // Timeout duration in seconds

];
