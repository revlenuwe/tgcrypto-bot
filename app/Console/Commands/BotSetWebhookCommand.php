<?php

namespace App\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Telegram\Bot\Laravel\Facades\Telegram;

class BotSetWebhookCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'bot:webhook {url}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set webhook for telegram bot';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
             Telegram::setWebhook([
                'url' => $this->argument('url')
            ]);

            $this->info('The Webhook was successfully set');
        } catch (Exception $e) {
            $this->error($e->getMessage());
        }
    }
}
