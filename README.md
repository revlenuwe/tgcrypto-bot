# Telegram crypto rates bot

T.G.C.R. is a fairly small bot that can be scaled to suit your needs.
To obtain data, the `codenix-sv/coingecko-api` and `blockchain/blockchain` libraries were used

## Getting started

Download source via Git

```bash
git clone https://github.com/revlenuwe/tgcrypto-bot.git
```
Run composer to install dependencies

```bash
composer install
```

## Configuration
By default, project comes with a `.env.example` file. You'll need to rename this file to just `.env`.

### Database
```bash
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=database
DB_USERNAME=username
DB_PASSWORD=password
```

After you changed the env values you can run the command:
```bash
php artisan migrate
```
**Remember:** Create the database before run artisan command

### General
Set your Telegram bot token:
```bash
TELEGRAM_BOT_TOKEN=your_token
```
After setting the token, you need to add a webhook, to set it you can simply follow the link:

[https://api.telegram.org/botBOT_TOKEN/setWebhook?url=https://yoursite.example/bot/webhook]()

The handler path `/bot/webhook` is set by default, but you can change it in `config/crypto-bot.php`

**The second option for installing the webhook is the command:**
```bash
php artisan bot:webhook https://yoursite.example/bot/webhook
```
Where  `https://yoursite.example/` is the domain of your site
### Advanced bot settings
In the `config/crypto-bot.php` config file you can configure some additional bot functions

```php
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
];
```
#### Notifications

The bot has a setting for notifications that runs on [Laravel's Scheduler](https://laravel.com/docs/8.x/scheduling)

```php
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
```
For notifications to work correctly, you'll need to add the following **cron** entry to your server:
```bash
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
```
# Commands preview
![Commands](https://i.imgur.com/2qDT9ok.png)
# For developers
To create new commands for the bot, you can use the command:
```bash
php artisan make:bot-command TestCommand
```
The template of the created command in `app/Http/Controllers/BotCommands/` looks like this:
```php
<?php

namespace App\Http\Controllers\BotCommands;

use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;

class TestCommand extends Command
{
    /**
     * @var string Command Name
     */
    protected $name = "test";

    /**
     * @var string Command Description
     */
    protected  $description = "...";

    /**
     * @inheritdoc
     */
    public function handle()
    {
        
    }
}
```
**After creating a command, it must be registered in `config/telegram.php`**

```php
'commands' => [
        //..
        App\Http\Controllers\BotCommands\TestCommand::class,
 ],
```

## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.


## License
[MIT](https://choosealicense.com/licenses/mit/)
