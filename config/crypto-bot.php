<?php

return [
    /**
    |--------------------------------------------------------------------------
    | Welcome message
    |--------------------------------------------------------------------------
    |
    | This text will be shown to every new user when entering the command /start
    |
    */

    'welcome_text' => 'Test',

    /**
    |--------------------------------------------------------------------------
    | Main currency
    |--------------------------------------------------------------------------
    |
    | Option to configure the main cryptocurrency, so far only used for the
    | standard argument of the command /price and notifications
    |
    */

    'main_currency' => 'btc',

    /**
    |--------------------------------------------------------------------------
    | Storing messages
    |--------------------------------------------------------------------------
    |
    | This option is responsible for saving user messages in database.
    | If the variable is set to true, then all messages will be saved
    | to the messages table.
    |
    */

    'store_messages' => true,

    /**
    |--------------------------------------------------------------------------
    | Webhook handler url (for route)
    |--------------------------------------------------------------------------
    |
    | Here you can declare the URL at which the handler for the telegram
    | webhook will be available.
    | When the url changes, you must set the telegram
    | webhook to https://yourdomain.example/WEBHOOK_HANDLER_URL
    |
    */

    'webhook_handler_url' => '/bot/webhook',

    /**
     *  Notifications settings
     */
    'schedule' => [

        /**
        |--------------------------------------------------------------------------
        | Recipient of notifications
        |--------------------------------------------------------------------------
        |
        | User or group chat ID that will receive endless cryptocurrency price
        | notifications.
        | To get your telegram ID you can use @getmyid_bot
        |
        */

        'notifications_telegram_id' => null,

        /**
        |--------------------------------------------------------------------------
        | Main currency price notification
        |--------------------------------------------------------------------------
        |
        | Here you can enable the notification of the price of the main
        | cryptocurrency.
        | Notifications will not work if the recipient chat ID is invalid
        |
        */

        'price_notification' => true,

        /**
        |--------------------------------------------------------------------------
        | Notification delay
        |--------------------------------------------------------------------------
        |
        | In this variable you can set the delay between price notifications
        | Choose one of the possible values:
        | "everyMinute", "everyFiveMinutes", "everyTenMinutes",
        | "everyThirtyMinutes", "hourly", "everySixHours", "daily"
        |
        */

        'price_notification_delay' => 'everyMinute',
    ]
];
