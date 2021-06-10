<?php

namespace Maestriam\Samurai\Console;

use Exception;
use Illuminate\Console\Command;
use Maestriam\Samurai\Exceptions\InvalidDirectiveNameException;
use Maestriam\Samurai\Support\Samurai;

class BaseCommand extends Command
{    
    /**
     * Cria a instância de um novo comando via console
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Retorna a mensagem de erro 
     *
     * @param mixed ...$params
     * @return integer
     */
    protected function success(...$params) : int
    {
        $info = vsprintf($this->successMessage, $params);
        
        $this->info($info);
        
        return 0;
    }
    
    /**
     * Retorna a mensagem de erro ao usuário junto com seu código. 
     *
     * @param Exception $e
     * @return integer
     */
    protected function failure(Exception $e) : int
    {
        $error = sprintf($this->errorMessage, $e->getMessage());

        $this->error($error);

        return $e->getCode();
    }

    /**
     * Retorna o nome do tema para execução.  
     * Em caso de nulo, tenta recuperar o tema atual da aplicação.  
     *
     * @return string
     */
    protected function getThemeArgument() : string
    {   
        $console = (string) $this->argument('theme');

        if (strlen($console)) {
            return $console;
        }

        return Samurai::base()->current()->package();
    }

    /**
     * Retorna o nome do nome da diretiva
     *
     * @return string
     */
    protected function getDirectiveArgument() : string
    {
        $name = (string) $this->argument('name');

        if ($name) {
            return $name;
        }
        
        throw new InvalidDirectiveNameException($name);
    }

    /**
     * Limpa o cache da aplicação Laravel
     *
     * @return void
     */
    protected function clean()
    {
        return Samurai::base()->clean();
    }
}