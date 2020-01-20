<?php

namespace Maestriam\Samurai\Console;

use Illuminate\Console\Command;
use Maestriam\Samurai\Traits\DirectiveHandling;

class CreateComponentCommand extends Command
{
    use DirectiveHandling;

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

        if ($this->directive()->exists($theme, $name, 'component')) {
            return $this->error('Este componente já existe nesse tema');
        }

        $this->directive()->component($theme, $name);
        $this->info('Componente criado com sucesso');
    }
}
