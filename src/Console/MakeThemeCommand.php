<?php

namespace Maestriam\Samurai\Console;

use Exception;
use Maestriam\Samurai\Support\Samurai;

class MakeThemeCommand extends BaseCommand
{
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
    protected $description = 'Create a new theme.';

    /**
     * Mensagem de sucesso ao executar o comando
     *
     * @var string
     */
    protected $successMessage = 'Theme [%s] created successful.';

    /**
     * Mensagem de erro ao executar o comando
     *
     * @var string
     */
    protected $errorMessage = 'Error to create theme: %s';

    /**
     * Executa o comando de console para criação
     *
     * @return mixed
     */
    public function handle()
    {
        try {

            $name = $this->argument('name');
            
            $theme = Samurai::theme($name)->make();  
            
            $this->clean();
            
            return $this->success($theme->name());
            
        } catch (Exception $e) {
            
            return $this->failure($e);
        }
    }
}
