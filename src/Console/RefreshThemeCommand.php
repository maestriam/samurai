<?php

namespace Maestriam\Samurai\Console;

use Exception;
use Illuminate\Console\Command;
use Maestriam\Samurai\Traits\Themeable;
use Maestriam\Samurai\Traits\Shared\ConfigAccessors;
use Maestriam\Samurai\Traits\Console\MessageLogging;

class RefreshThemeCommand extends Command
{
    /**
     * Propriedades e funções básicas do sistema
     */
    use Themeable, ConfigAccessors, MessageLogging;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'samurai:refresh';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refresh current theme in Laravel Project.';

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
        try {
            
            $this->base()->clearCache();
    
            return $this->success('theme.refresh');
        
        } catch (Exception $e) {
            return $this->failed($e->getCode());
        }
    }
}
