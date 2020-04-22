<?php

namespace Maestriam\Samurai\Console;

use Exception;
use Illuminate\Console\Command;
use Maestriam\Samurai\Traits\Themeable;
use Maestriam\Samurai\Traits\Shared\ConfigAccessors;
use Maestriam\Samurai\Traits\Console\MessageLogging;

class PublishThemeCommand extends Command
{
    use Themeable, ConfigAccessors, MessageLogging;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'samurai:publish {theme}';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Executa o comando para publicação de assets do tema
     *
     * @return void
     */
    public function handle()
    {
        try {

            $name = (string) $this->argument('theme');

            $this->theme($name)->publish();
            
            $this->base()->clearCache();

            return $this->success('theme.published');

        } catch (Exception $e) {

            return $this->failed($e->getCode());
        }
    }
}
