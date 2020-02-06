<?php

namespace Maestriam\Samurai\Console;

use Exception;
use Illuminate\Console\Command;
use Maestriam\Samurai\Traits\ThemeHandling;
use Maestriam\Samurai\Traits\ConsoleLog;

class PublishThemeCommand extends Command
{
    use ThemeHandling, ConsoleLog;

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
            
            $theme = $this->argument('theme');
            
            $this->theme()->publish($theme);

            return $this->success('themes.published');

        } catch (Exception $e) {
       
            return $this->failed($e->getMessage(), $e->getCode());
        }
    }
}
