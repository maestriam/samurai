<?php

namespace Maestriam\Samurai\Console;

use Exception;
use Illuminate\Console\Command;
use Maestriam\Samurai\Traits\Themeable;
use Maestriam\Samurai\Traits\Shared\ConfigAccessors;
use Maestriam\Samurai\Traits\Console\MessageLogging;

class MakeComponentCommand extends Command
{
    use Themeable, ConfigAccessors, MessageLogging;

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
        try {

            $theme = (string) $this->argument('theme');
            $name  = (string) $this->argument('name');

            $this->theme($theme)->component($name)->create();

            return $this->success('component.created');

        } catch (Exception $e) {
            return $this->failed($e->getCode());
        }
    }
}
