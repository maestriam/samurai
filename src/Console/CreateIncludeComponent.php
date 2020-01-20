<?php

namespace Maestriam\Samurai\Console;

use Illuminate\Console\Command;
use Maestriam\Samurai\Traits\ThemeHandling;
use Maestriam\Samurai\Traits\DirectiveHandling;

class CreateIncludeCommand extends Command
{
    use DirectiveHandling;

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

        if ($this->directive()->exists($theme, $name, 'include')) {
            return $this->error('Este include já existe nesse tema');
        }

        $this->directive()->include($theme, $name);
        $this->info('Include criado com sucesso');
    }
}
