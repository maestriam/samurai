<?php

namespace Maestriam\Samurai\Console;

use Illuminate\Console\Command;
use Maestriam\Samurai\Traits\ThemeHandling;
use Maestriam\Samurai\Traits\DirectiveHandling;

class CreateComponentCommand extends Command
{
    use ThemeHandling, DirectiveHandling;

    /**
     * Tipo de diretiva que deseja está predestinado a construir
     *
     * @var string
     */
    protected $type = 'component';

    /**
     * Assinatura Artisan
     *
     * @var string
     */
    protected $signature = 'katana:make-component {theme} {name}';

    /**
     * Descrição do comando Artisan
     *
     * @var string
     */
    protected $description = 'Create a new component for specific theme';

    /**
     * Classe construtora de arquivos de diretivas
     *
     * @var DirectiveHandler
     */
    protected $directive;

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

        if (! $this->themeExists($theme)) {
            return $this->info(__('katana::console.theme.not-exists'));
        }

        if ($this->directive()->exists($this->type, $theme, $name)) {
            return $this->info(__('katana::console.component.exists'));
        }

        $this->createComponent($theme, $name);
    }

    /**
     * Executa o comando para criar o arquivo  com sua sub-pasta
     * no tema desejado
     *
     * @param string $theme
     * @param string $name
     * @return void
     */
    public function createComponent($theme, $name)
    {
        $this->directive()->create($this->type, $theme, $name);
    }
}
