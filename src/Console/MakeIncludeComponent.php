<?php

namespace Maestriam\Samurai\Console;

use Illuminate\Console\Command;
use Maestriam\Samurai\Traits\ThemeHandling;
use Maestriam\Samurai\Traits\ConsoleLog;
use Maestriam\Samurai\Traits\DirectiveHandling;

class MakeIncludeCommand extends Command
{
    use ThemeHandling, DirectiveHandling, ConsoleLog;

    /**
     * Assinatura Artisan
     *
     * @var string
     */
    protected $signature = 'samurai:make-include {theme} {name}';

    /**
     * Descrição do comando Artisan
     *
     * @var string
     */
    protected $description = 'Create a new include for specific theme';

    /**
     * Construção da classe
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Executa o comando de criação de includee atráves do Artisan
     *
     * @return void
     */
    public function handle()
    {
        $theme = (string) $this->argument('theme');
        $name  = (string) $this->argument('name');

        if (! $this->theme()->exists($theme)) {
            return $this->failed('theme.not-exists', 103, true);
        }

        if ($this->directive()->exists($theme, $name, 'include')) {
            return $this->failed('include.exists', 201, true);
        }

        $directive = $this->directive()->include($theme, $name);

        if ($directive == null) {
            return $this->failed('include.invalid', 3);
        }

        return $this->success('include.created', 0);
    }
}
