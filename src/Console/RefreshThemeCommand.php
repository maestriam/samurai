<?php

namespace Maestriam\Samurai\Console;

use Exception;

class RefreshThemeCommand extends BaseCommand
{
    /**
     * {@inheritDoc}
     */
    protected $signature = 'samurai:refresh';

    /**
     * {@inheritDoc}
     */
    protected $description = 'Refresh cache and view in Laravel Project.';

    /**
     * {@inheritDoc}
     */
    protected string $successMessage = 'Cache and views are refreshed.';

    /**
     * {@inheritDoc}
     */
    protected string $errorMessage = 'Error to refresh project: %s';

    /**
     * Executa o comando de console
     *
     * @return mixed
     */
    public function handle()
    {            
        try {

            $this->clean();

            return $this->success();
            
        } catch (Exception $e) {

            return $this->failure($e);
        }
    }
}
