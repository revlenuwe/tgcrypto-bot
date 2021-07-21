<?php

return [
    'welcome_text' => 'Test',

    'main_currency' => 'btc',

    'notifications_telegram_id' => null,

    'schedule' => [
        'price_notification' => true,

        /**
         * everyMinute
         * everyFiveMinutes
         * everyTenMinutes
         * everyThirtyMinutes
         * hourly
         * everySixHours
         * daily
         */

        'price_notification_delay' => 'everyMinute',
    ]
];
