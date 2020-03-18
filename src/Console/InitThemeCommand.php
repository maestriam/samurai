<?php

namespace Maestriam\Samurai\Console;
use Exception;
use Illuminate\Console\Command;
use Maestriam\Samurai\Traits\Themeable;
use Maestriam\Samurai\Traits\ConsoleLog;

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
        $answers = [];
        
        $questions = [
            $this->getNameAsk(), 
            $this->getDescriptionAsk(), 
            $this->getAuthorAsk()
        ];

        foreach ($questions as $question) {
            
            $answer = $this->ask($question->ask);
            
            if (! $answer) {
                $answer = $question->default;
            }

            $answers[] = $answer;
        }

        // $this->preview($answers);
    }
    
    /**
     * Retorna a mensagem da pergunta, junto com os 
     * dados de nome do distribuidor com uma sugestão 
     * de nome para o tema, junto com configurações do projeto
     *
     * @return object
     */
    private function getNameAsk() : object
    {
        $theme    = $this->base()->suggestName();
        $question = sprintf('Theme name (<vendor/name>) [%s]', $theme);
        
        return (object) [
            'ask'     => $question,
            'default' => $theme
        ];
    }

    /**
     * Retorna a mensagem da pergunta, junto com os 
     * dados de nome do distribuidor com uma sugestão 
     * de nome para o tema, junto com configurações do projeto
     *
     * @return object
     */
    private function getDescriptionAsk() : object
    {
        $desc     = "";
        $question = sprintf("Description [%s]", $desc); 

        return (object) [
            'ask'     => $question,
            'default' => $desc
        ];
    }

    /**
     * Retorna a mensagem da pergunta, junto com os 
     * dados do autor de acordo com os  arquivos de 
     * configurações do projeto
     *
     * @return string
     */
    public function getAuthorAsk() : object
    {
        $author  = $this->base()->author();
        $name    = $author->name;
        $email   = $author->email;
        $suggest = sprintf("%s <%s>", $name, $email);

        $ask = sprintf('Author [%s]', $suggest);

        return (object) [
            'ask'     => $ask,
            'default' => $suggest
        ];
    }

    /**
     * Retorna a preview de como ficará o arquivo composer.json
     * do tema que será criado
     *
     * @param array $answers
     * @return string
     */
    public function preview(array $answers) : string
    {
        if (count($answers) == 2 ) {
            throw new Exception("Error Processing Request", 1);
        }

        $name   = $answers[0];
        $author = $answers[1];

        $content = $this->theme($name, $author)->preview();

        return $content;
    }
}