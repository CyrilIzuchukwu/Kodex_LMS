<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Registration Settings
    |--------------------------------------------------------------------------
    |
    | This option controls whether a new user registration is enabled.
    | When disabled, the registration routes will be unavailable.
    |
    */
    'register' => [
        'enabled' => true,
    ],

    'social_login' => [
        'enabled' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Email Settings
    |--------------------------------------------------------------------------
    |
    | Configuration for email-related features in the admin panel.
    |
    */
    'email_notification' => true,    // Enable/disable all email notifications
    'email_provider' => 'phpmailer',      // Default mailer service to use for all emails
];
