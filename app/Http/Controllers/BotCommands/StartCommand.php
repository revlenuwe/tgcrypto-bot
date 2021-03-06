<?php


namespace App\Http\Controllers\BotCommands;


use App\Models\User;
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
        $chatId = $this->getUpdate()->getMessage()->getChat()->getId();

        $user = User::where('chat_id', $chatId)->first();

        if(!$user){
            User::create([
                'chat_id' => $chatId,
                'username' => $this->getUpdate()->getMessage()->getChat()->getUsername(),
                'name' => $this->getUpdate()->getMessage()->getChat()->getFirstName(),
            ]);
        }

        $this->replyWithMessage([
            'text' => config('bot.welcome_text', 'Welcome ' . $this->getUpdate()->getMessage()->getChat()->getUsername())
        ]);
    }
}
