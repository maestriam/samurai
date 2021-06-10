<?php

namespace Maestriam\Samurai\Console;

use Exception;
use Maestriam\Samurai\Support\Samurai;

class PublishThemeCommand extends BaseCommand
{
    /**
     * {@inheritDoc}
     */
    protected $signature = 'samurai:publish {theme}';

    /**
     * {@inheritDoc}
     */
    protected $description = 'Publish assets folder to public folder.';

    /**
     * {@inheritDoc}
     */
    protected string $successMessage = 'Theme [%s] published successful.';

    /**
     * {@inheritDoc}
     */
    protected string $errorMessage = 'Error to publish theme: %s';

    /**
     * Executa o comando para publicação de assets do tema
     *
     * @return void
     */
    public function handle()
    {
        try {

            $name = (string) $this->argument('theme');

            $theme = Samurai::theme($name);
            
            $ret = $theme->publish();

            return $this->success($theme->package());

        } catch (Exception $e) {

            return $this->failure($e);
        }
    }
}
