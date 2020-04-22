<?php

namespace Maestriam\Samurai\Console;

use Lang;
use Exception;
use Illuminate\Console\Command;
use Maestriam\Samurai\Traits\Themeable;
use Maestriam\Samurai\Traits\Shared\ConfigAccessors;
use Maestriam\Samurai\Traits\Console\MessageLogging;

class MakeIncludeCommand extends Command
{
    use Themeable, ConfigAccessors, MessageLogging;

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
        try {   

            $theme = (string) $this->argument('theme');
            $name  = (string) $this->argument('name');
            
            $include = $this->theme($theme)->include($name)->create();
            
            $this->base()->clearCache();

            return $this->created($include, 'include');

        } catch (Exception $e) {
            return $this->failed($e->getCode());
        }
    }
}
