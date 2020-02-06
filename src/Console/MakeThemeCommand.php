<?php

namespace Maestriam\Samurai\Console;

use Exception;
use Illuminate\Console\Command;
use Maestriam\Samurai\Traits\ConsoleLog;
use Maestriam\Samurai\Traits\ThemeHandling;

class MakeThemeCommand extends Command
{
    /**
     * Propriedades e funções básicas do sistema
     */
    use ThemeHandling, ConsoleLog;

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

        if ($this->theme()->exists($name)) {
            return $this->failed('theme.exists', 102, true);
        }

        try {
            
            $theme = $this->theme()->create($name);

            return $this->success('theme.created', 0 ,true);
        
        } catch (Exception $e) {
            return $this->failed($e->getMessage(), $e->getCode());
        }   
    }
}
