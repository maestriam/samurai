<?php

namespace Maestriam\Samurai\Console;

use Illuminate\Console\Command;
use Maestriam\Samurai\Traits\ThemeHandling;
use Maestriam\Samurai\Traits\DirectiveHandling;

class CreateIncludeCommand extends Command
{
    use ThemeHandling, DirectiveHandling;

    /**
     * Tipo de diretiva que deseja está predestinado a construir
     *
     * @var string
     */
    protected $type = 'include';

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

        if (! $this->themeExists($theme)) {
            return $this->info(__('Samurai::console.theme.not-exists'));
        }

        if ($this->directive()->exists($this->type, $theme, $name)) {
            return $this->info(__('Samurai::console.include.exists'));
        }

        $this->createinclude($theme, $name);
    }

    /**
     * Executa o comando para criar o arquivo  com sua sub-pasta
     * no tema desejado
     *
     * @param string $theme
     * @param string $name
     * @return void
     */
    public function createinclude($theme, $name)
    {
        $this->directive()->create($this->type, $theme, $name);
    }
}
