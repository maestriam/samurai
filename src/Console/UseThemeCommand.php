<?php

namespace Maestriam\Samurai\Console;

use Exception;
use Maestriam\Samurai\Support\Samurai;

class UseThemeCommand extends BaseCommand
{
    /**
     * {@inheritDoc}
     */
    protected $signature = 'samurai:use {theme}';
    
    /**
     * {@inheritDoc}
     */
    protected $description = 'Refresh cache and view in Laravel Project.';

    /**
     * {@inheritDoc}
     */
    protected string $successMessage = 'Theme [%s] is current and ready to use.';

    /**
     * {@inheritDoc}
     */
    protected string $errorMessage = 'Error to refresh project: %s';

    /**
     * Executa o comando para publicação de assets do tema
     *
     * @return void
     */
    public function handle()
    {
        try {

            $name = (string) $this->argument('theme');

            Samurai::theme($name)->use()->publish();
            
            $this->clean();

            return $this->success($name);

        } catch (Exception $e) {
            return $this->failure($e);
        }
    }
}
