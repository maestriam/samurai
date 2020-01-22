<?php

namespace Maestriam\Samurai\Console;

use Illuminate\Console\Command;
use Maestriam\Samurai\Traits\ThemeHandling;
use Maestriam\Samurai\Traits\LoggingMessages;
use Maestriam\Samurai\Traits\DirectiveHandling;

class CreateComponentCommand extends Command
{
    use DirectiveHandling, ThemeHandling, LoggingMessages;

    /**
     * Assinatura Artisan
     *
     * @var string
     */
    protected $signature = 'samurai:make-component {theme} {name}';

    /**
     * Descrição do comando Artisan
     *
     * @var string
     */
    protected $description = 'Create a new component for specific theme';

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
     * Executa o comando de criação de componente atráves do Artisan
     *
     * @return void
     */
    public function handle()
    {
        $theme = (string) $this->argument('theme');
        $name  = (string) $this->argument('name');

        if (! $this->theme()->exists($theme)) {
            return $this->_error('theme.not-exists', 1);
        }

        if ($this->directive()->exists($theme, $name, 'component')) {
            return $this->_error('component.exists', 2);
        }

        $directive = $this->directive()->component($theme, $name);

        if ($directive == null) {
            return $this->_error('component.invalid', 3);
        }

        return $this->_success('component.created');
    }
}
