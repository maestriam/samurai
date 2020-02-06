<?php

namespace Maestriam\Samurai\Console;

use Exception;
use Illuminate\Console\Command;
use Maestriam\Samurai\Traits\ThemeHandling;
use Maestriam\Samurai\Traits\ConsoleLog;
use Maestriam\Samurai\Traits\DirectiveHandling;

class MakeComponentCommand extends Command
{
    use DirectiveHandling, ThemeHandling, ConsoleLog;

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

        try {
        
            $directive = $this->directive()->component($theme, $name);

            return $this->success('component.created');

        } catch (Exception $e) {
            return $this->failed($e->getMessage(), $e->getCode());
        }
    }
}
