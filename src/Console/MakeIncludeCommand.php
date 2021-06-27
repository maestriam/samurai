<?php

namespace Maestriam\Samurai\Console;

use Exception;
use Maestriam\Samurai\Support\Samurai;

class MakeIncludeCommand extends BaseCommand
{
    /**
     * {@inheritDoc}
     */
    protected $signature = 'samurai:make-include {name} {theme?}';

    /**
     * {@inheritDoc}
     */
    protected $description = 'Create a new include for a specific theme';

    /**
     * {@inheritDoc}
     */
    protected string $successMessage = 'Include [%s] created in %s';

    /**
     * {@inheritDoc}
     */
    protected string $errorMessage = 'Error to create include: %s';

    /**
     * Executa o comando de criação de include atráves do Artisan
     *
     * @return void
     */
    public function handle()
    {
        try {
            
            $name = $this->getDirectiveArgument();

            $theme = $this->getThemeArgument();

            $include = Samurai::theme($theme)->include($name)->create();

            $this->clean();

            return $this->success($name, $include->relative());

        } catch (Exception $e) {
            return $this->failure($e);
        }
    }
}
