<?php

namespace Maestriam\Samurai\Console;

use Exception;
use Maestriam\Samurai\Support\Samurai;

class MakeComponentCommand extends BaseCommand
{
    /**
     * {@inheritDoc}
     */
    protected $signature = 'samurai:make-component {name} {theme?}';

    /**
     * {@inheritDoc}
     */
    protected $description = 'Create a new component for specific theme';

    /**
     * {@inheritDoc}
     */
    protected string $successMessage = 'Component [%s] created into [%s]: %s';

    /**
     * {@inheritDoc}
     */
    protected string $errorMessage = 'Error to create component: %s';

    /**
     * Executa o comando de criação de componente atráves do Artisan
     *
     * @return void
     */
    public function handle()
    {
        try {

            $name = $this->getDirectiveArgument();

            $theme = $this->getThemeArgument();

            $component = Samurai::theme($theme)->component($name)->create();

            Samurai::base()->clean();

            return $this->success($name, $theme, $component->relative());

        } catch (Exception $e) {
            return $this->failure($e);
        }
    }
}
