<?php


namespace App\Http\Controllers\BotCommands;


use Telegram\Bot\Commands\Command;

class StartCommand extends Command
{
    /**
     * @var string Command Name
     */
    protected $name = "start";

    /**
     * @var string Command Description
     */
    protected $description = "...";

    /**
     * @inheritdoc
     */
    public function handle()
    {
        $this->replyWithMessage([
            'text' => config('bot.welcome_text', 'Welcome' . $this->update->getChat()->username)
        ]);
    }
}
