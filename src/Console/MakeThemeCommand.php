<?php

namespace Maestriam\Samurai\Console;

use Exception;
use Illuminate\Console\Command;
use Maestriam\Samurai\Traits\Themeable;
use Maestriam\Samurai\Traits\Shared\ConfigAccessors;
use Maestriam\Samurai\Traits\Console\MessageLogging;

class MakeThemeCommand extends Command
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
        try {

            $name = $this->argument('name');

            $this->theme($name)->build();

            return $this->success('theme.created');

        } catch (Exception $e) {

            return $this->failed($e->getCode());
        }
    }
}
