<?php

namespace Maestriam\Samurai\Console;

use Exception;
use Maestriam\Samurai\Entities\Wizard;
use Maestriam\Samurai\Support\Samurai;

class InitThemeCommand extends BaseCommand
{
    /**
     * {@inheritDoc}
     */
    protected $signature = 'samurai:init';

    /**
     * {@inheritDoc}
     */
    protected $description = 'Create a new theme using interactive mode';

    /**
     * {@inheritDoc}
     */
    protected string $successMessage = 'Theme [%s] created successful.';

    /**
     * {@inheritDoc}
     */
    protected string $errorMessage = 'Error to create theme: %s';

    /**
     * Executa o comando de criação de componente atráves do Artisan
     *
     * @return void
     */
    public function handle()
    {
        try {

            $name   = $this->askTheme();
            $author = $this->askAuthor();            
            $descr  = $this->askDescription();   
            
            if (! $this->beSure($name, $author, $descr)) {
                return false;
            }
            
            $theme = Samurai::theme($name);
                        
            $theme->author($author)->description($descr)->make();
            
            $this->clean();

            return $this->success($name);

        } catch (Exception $e) {
            return $this->failure($e);
        }
    }
    
    /**
     * Retorna o nome do vendor/tema escolhido pelo usuário
     *
     * @return string
     */
    private function askTheme() : string 
    {
        $question = $this->wizard()->theme();

        return $this->askFor($question);
    }
    
    /**
     * Retorna o autor do tema informado pelo usuário
     *
     * @return string
     */
    private function askAuthor() : string
    {
        $question = $this->wizard()->author();

        return $this->askFor($question); 
    } 

    /**
     * Retorna a descrição do tema informado pelo usuário
     *
     * @return string
     */
    private function askDescription() : string
    {
        $question = $this->wizard()->description();

        return $this->askFor($question);        
    } 

    /**
     * Retorna a resposta de uma pergunta feita para o usuário
     *
     * @param object $question
     * @return string
     */
    private function askFor(object $question) : string
    {
        $answer = $this->ask($question->ask);

        return (! $answer || empty($answer)) ? $question->default : $answer;
    } 

    /**
     * Retorna se está de acordo para a criação do tema 
     *
     * @param string $theme
     * @param string $author
     * @param string $desc
     * @return boolean
     */
    private function beSure(string $theme, string $author, string $desc) : bool
    {
        $question = $this->wizard()->confirm($theme, $author, $desc); 

        return $this->confirm($question->ask);
    }

    /**
     * Retorna a instância do auxiliar com as perguntas do prompt e
     * respostas padrão para a criação do tema.  
     *
     * @return Wizard
     */
    private function wizard() : Wizard
    {
        return Samurai::wizard();
    }
}
