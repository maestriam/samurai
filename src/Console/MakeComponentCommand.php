<?php

namespace Maestriam\Samurai\Console;

use Exception;
use Maestriam\Samurai\Support\Samurai;

class MakeComponentCommand extends BaseCommand
{
    /**
     * Assinatura Artisan
     *
     * @var string
     */
    protected $signature = 'samurai:make-component {name} {theme?}';

    /**
     * Descrição do comando Artisan
     *
     * @var string
     */
    protected $description = 'Create a new component for specific theme';

    /**
     * Mensagem de sucesso ao executar o comando
     *
     * @var string
     */
    protected $successMessage = 'Component [%s] created in %s';

    /**
     * Mensagem de erro ao executar o comando
     *
     * @var string
     */
    protected $errorMessage = 'Error to create component: %s';

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

            return $this->success($name, $component->path());

        } catch (Exception $e) {
            return $this->failure($e);
        }
    }
}
