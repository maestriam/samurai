<?php

namespace Maestriam\Samurai\Console;

use Exception;
use Maestriam\Samurai\Support\Samurai;

class MakeThemeCommand extends BaseCommand
{
    /**
     * {@inheritDoc}
     */
    protected $signature = 'samurai:make-theme {name}';

    /**
     * {@inheritDoc}
     */
    protected $description = 'Create a new theme.';

    /**
     * {@inheritDoc}
     */
    protected string $successMessage = 'Theme [%s] created successful.';

    /**
     * {@inheritDoc}
     */
    protected string $errorMessage = 'Error to create theme: %s';

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
            
            return $this->success($theme->package());
            
        } catch (Exception $e) {
            
            return $this->failure($e);
        }
    }
}
