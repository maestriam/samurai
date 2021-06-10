<?php

namespace Maestriam\Samurai\Console;

use Exception;
use Maestriam\Samurai\Support\Samurai;

class MakeIncludeCommand extends BaseCommand
{
    /**
     * Assinatura Artisan
     *
     * @var string
     */
    protected $signature = 'samurai:make-include {name} {theme?}';

    /**
     * Descrição do comando Artisan
     *
     * @var string
     */
    protected $description = 'Create a new include for a specific theme';

    /**
     * Mensagem de sucesso ao executar o comando
     *
     * @var string
     */
    protected $successMessage = 'Include [%s] created in %s';

    /**
     * Mensagem de erro ao executar o comando
     *
     * @var string
     */
    protected $errorMessage = 'Error to create include: %s';

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

            Samurai::base()->clean();

            return $this->success($name, $include->path());

        } catch (Exception $e) {
            return $this->failure($e);
        }
    }
}
