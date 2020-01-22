<?php

namespace Maestriam\Samurai\Console;

use Illuminate\Console\Command;
use Maestriam\Samurai\Traits\ThemeHandling;

class PublishThemeCommand extends Command
{
    use ThemeHandling;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'samurai:publish-theme {theme}';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $theme = $this->argument('theme');

        $this->theme()->publish($theme);
    }
}
