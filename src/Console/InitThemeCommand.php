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
            $this->getThemeAsk(), 
            $this->getDescriptionAsk(), 
            $this->getAuthorAsk()
        ];
        
        foreach ($questions as $question) {
            
            $answer = $this->ask($question->ask);
            
            if (! $answer) {
                $answer = $question->default;
            }

            $k = $question->key;
            $answers[$k] = $answer;
        }

        $this->preview($answers);
    }
    
    /**
     * Retorna a mensagem da pergunta, junto com os 
     * dados de nome do distribuidor com uma sugestão 
     * de nome para o tema, junto com configurações do projeto
     *
     * @return object
     */
    private function getThemeAsk() : object
    {
        $theme    = $this->default()->name();
        $question = sprintf('Name (<vendor/name>) [%s]', $theme);
        
        return (object) [
            'key'     => 'theme',
            'ask'     => $question,
            'default' => $theme
        ];
    }

    /**
     * Retorna a pergunta de quem será o autor do projeto,
     * junto com os dados padrão em caso nulo
     *
     * @return object
     */
    private function getDescriptionAsk() : object
    {
        $desc     = $this->default()->description();
        $question = sprintf("Description [%s]", $desc); 

        return (object) [
            'key'     => 'description',
            'ask'     => $question,
            'default' => $desc
        ];
    }

    /**
     * Retorna a pergunta de quem será o autor do projeto,
     * junto com os dados padrão em caso nulo
     *
     * @return string
     */
    public function getAuthorAsk() : object
    {
        $author  = $this->default()->author();
        $name    = $author->name;
        $email   = $author->email;
        $suggest = sprintf("%s <%s>", $name, $email);

        $ask = sprintf('Author [%s]', $suggest);

        return (object) [
            'key'     => 'author',
            'ask'     => $ask,
            'default' => $suggest
        ];
    }

    /**
     * Interpreta a resposta do usuário para pegar 
     * o e-mail e nome do autor
     *
     * @param string $author
     * @return void
     */
    protected function parseAuthor(string $author)
    {
        $pieces = explode(' <', $author);

        $json = [
            'name'  => $pieces[0], 
            'email' => str_replace('>', '', $pieces[1]), 
        ];

        return $json;
    }
    
    /**
     * Retorna a preview de como ficará o arquivo composer.json
     * do tema que será criado
     *
     * @param array $answers
     * @return string
     */
    public function preview(array $answers)
    {
        $authors =  $this->parseAuthor($answers['author']); 
                
        $content = $this->stub('composer');

        $content = str_replace('{{theme}}', $answers['theme'], $content);
        $content = str_replace('{{description}}', $answers['description'], $content);
        $content = str_replace('{{name}}', $authors['name'], $content);
        $content = str_replace('{{email}}', $authors['email'], $content);
        $content = str_replace('\r\n', PHP_EOL, $content);
        
        if ($this->confirm('Confirm? '.PHP_EOL . $content)) {
            $this->composerFile($content);
        }
    }

    public function composerFile($content)
    {
        $handle = fopen('composer.x.json', 'w');

        fwrite($handle, $content);

        return fclose($handle);
    }

    public function stub(string $filename) : string
    {
        $pattern = __DIR__ . DS .  "../Stubs/%s.stub";
        $file    = sprintf($pattern, $filename);

        if (! is_file($file)) {
            throw new StubNotFoundException($file);
        }

        return file_get_contents($file);
    }

}