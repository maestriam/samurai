<?php

namespace Maestriam\Samurai\Console;

use Exception;
use Illuminate\Console\Command;
use Maestriam\Samurai\Traits\Themeable;
use Maestriam\Samurai\Traits\ConsoleLog;
use Maestriam\Samurai\Exceptions\StubNotFoundException;

class InitThemeCommand extends Command
{
    use Themeable, ConsoleLog;

    /**
     * Assinatura Artisan
     *
     * @var string
     */
    protected $signature = 'samurai:init';

    /**
     * Descrição do comando Artisan
     *
     * @var string
     */
    protected $description = 'Create a new theme';

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
     * Executa o comando de criação de componente atráves do Artisan
     *
     * @return void
     */
    public function handle()
    {
        try {

            $theme = $this->askTheme();
            $cmd   = $this->theme($theme);

            $author = $this->askAuthor();
            $cmd->author($author);

            $desc = $this->askDescription();   
            $cmd->description($desc);
            
            if (! $this->beSure($theme, $author, $desc)) {
                return false;
            }

            $this->theme($theme)
                 ->author($author)
                 ->description($desc)
                 ->build();

            return $this->success('theme.created');

        } catch (Exception $e) {
            return $this->failed($e->getMessage(), $e->getCode(), true);
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
        $answer   = $this->askFor($question);

        return $answer;
    }

    
    /**
     * Retorna o autor do tema informado pelo usuário
     *
     * @return string
     */
    private function askAuthor() : string
    {
        $question = $this->wizard()->author();
        $answer   = $this->askFor($question); 

        return $answer;      
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
}
