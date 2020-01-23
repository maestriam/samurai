<?php

namespace Maestriam\Samurai\Console;

use Illuminate\Console\Command;
use Maestriam\Samurai\Traits\ThemeHandling;
use Maestriam\Samurai\Traits\LoggingMessages;

class CreateThemeCommand extends Command
{
    /**
     * Propriedades e funções básicas do sistema
     */
    use ThemeHandling, LoggingMessages;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'samurai:make-theme {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new katana-based theme.';

    /**
     * Define as propriedades principais do pacote
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Executa o comando de console
     *
     * @return mixed
     */
    public function handle()
    {
        $name  = $this->argument('name');
        $theme = $this->theme()->create($name);

        if ($this->theme()->exists($theme->name)) {
            return $this->info('Tema '.$theme->name.' criado com sucesso');
        }

        return $this->error('Não foi possível criar o tema.');
    }
}
