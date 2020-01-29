<?php

namespace Maestriam\Samurai\Console;

use Illuminate\Console\Command;
use Maestriam\Samurai\Traits\ThemeHandling;
use Maestriam\Samurai\Traits\LoggingMessages;

class PublishThemeCommand extends Command
{
    use ThemeHandling, LoggingMessages;

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
        $theme = $this->argument('theme');

        if (! $this->theme()->exists($theme)) {
            return $this->_error('theme.not-exists', 1);
        }

        $this->theme()->publish($theme);

        return $this->_success('themes.published');
    }
}
