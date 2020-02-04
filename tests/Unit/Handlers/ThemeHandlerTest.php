<?php

namespace Maestriam\Samurai\Unit\Handlers;

use Tests\TestCase;
use ArgumentCountError;
use Maestriam\Samurai\Models\Theme;
use Maestriam\Samurai\Models\Directive;
use Maestriam\Samurai\Traits\ThemeHandling;
use Illuminate\Foundation\Testing\WithFaker;
use Maestriam\Samurai\Traits\DirectiveHandling;
use Maestriam\Samurai\Exceptions\InvalidThemeNameException;

class ThemeHandlerTest extends TestCase
{
    use WithFaker, ThemeHandling, DirectiveHandling;

    /**
     * Verifica se a função para trazer o diretório base de temas
     * retorna o caminho corretamente
     *
     * @return void
     */
    public function testBaseFolder()
    {
        $path = $this->theme()->baseFolder();

        $this->assertIsString($path);
    }

    /**
     * Verifica se o serviço consegue criar o diretório-base
     * para o armazemanento de temas
     */
    public function testMakeBase()
    {
        $path = $this->theme()->makeBase();

        $this->assertIsString($path);
        $this->assertDirectoryExists($path);
        $this->assertDirectoryIsReadable($path);
        $this->assertDirectoryIsWritable($path);
    }

    /**
     * Verifica se o serviço consegue trazer os temas dentro do
     * diretório-base
     *
     * @return void
     */
    public function testAllThemes()
    {
        $folders = $this->theme()->all();

        $this->assertIsArray($folders);
    }

    /**
     * Verifica se consegue pegar o primeiro tema que encontrar
     * dentro do diretório-base
     *
     * @return void
     */
    public function testFirstTheme()
    {
        $theme = $this->faker->word();

        $this->theme()->create($theme);

        $first = $this->theme()->first();

        $this->assertInstanceOf(Theme::class, $first);
    }

    /**
     * Verifica se o serviço consegue
     *
     * @return void
     */
    public function testCreateTheme()
    {
        $theme = $this->faker->word();

        $object = $this->theme()->create($theme);

        $this->assertInstanceOf(Theme::class, $object);

        $this->assertObjectHasAttribute('name', $object);
        $this->assertObjectHasAttribute('path', $object);
        $this->assertObjectHasAttribute('namespace', $object);

        $this->assertNotEmpty($object->name);
        $this->assertNotEmpty($object->path);
        $this->assertNotEmpty($object->namespace);

        $this->assertDirectoryExists($object->path);
        $this->assertDirectoryIsReadable($object->path);
        $this->assertDirectoryIsWritable($object->path);
    }

    /**
     * Verifica se todas as subpastas do tema
     * foram criadas com sucesso e com as permissões corretas
     *
     * @return void
     */
    public function testSubfolderTheme()
    {
        $name = $this->faker->word();
        $structure = $this->theme()->structure();

        $theme = $this->theme()->create($name);

        foreach($structure as $t => $folder) {

            $path = $theme->path . DS . $folder;

            $this->assertDirectoryExists($path);
            $this->assertDirectoryIsReadable($path);
            $this->assertDirectoryIsWritable($path);
        }
    }

    /**
     * Valida se é um nome correto para tema
     *
     * @return void
     */
    public function testIsValidThemeName()
    {
        $theme = $this->faker->word();

        $check = $this->theme()->isValidName($theme);

        $this->assertIsBool($check);
        $this->assertTrue($check);
    }

    /**
     * Valida se é um nome INCORRETO, passando caracteres especiais,
     * para o tema é validado corretamente
     *
     * @return void
     */
    public function testIsInvalidNameWithSpecialChars()
    {
        $regexSpecial = '[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}';
        $special = $this->faker->regexify($regexSpecial);

        $check = $this->theme()->isValidName($special);

        $this->assertIsBool($check);
        $this->assertFalse($check);
    }

    /**
     * Valida se é um nome INCORRETO, passando números no começo,
     * para o tema é validado corretamente
     *
     * @return void
     */
    public function testInvalidNameWithNumbers()
    {
        $regexNumbers = '[0-9]{*}+@[a-zA-Z]';

        $number = $this->faker->regexify($regexNumbers);
        $check  = $this->theme()->isValidName($number);

        $this->assertIsBool($check);
        $this->assertFalse($check);
    }

    /**
     * Valida se é possível criar um tema com
     *
     * @return void
     */
    public function testCreateThemeNameWithNumberName()
    {
        $theme = '123theme';

        $this->expectException(InvalidThemeNameException::class);

        $this->theme()->create($theme);
    }

    /**
     * Valida se é possível criar um tema com caracteres especiais
     *
     * @return void
     */
    public function testCreateThemeWithSpecialCharsName()
    {
        $theme = 'it$-my-th3m3!';

        $this->expectException(InvalidThemeNameException::class);

        $this->theme()->create($theme);
    }

    /**
     * Tentar criar um tema sem passar o nome do tema
     *
     * @return void
     */
    public function testeCreateThemeWithoutName()
    {
        $this->expectException(ArgumentCountError::class);

        $theme = $this->theme()->create();
    }

    /**
     * Valida se é possível publicar os assets de um determinado
     * tema
     *
     * @return void
     */
    public function testPublishTheme()
    {
        $name  = $this->faker->word();
        $theme = $this->theme()->create($name);
        $dist  = public_path('themes'. DS . $theme->name);

        $check = $this->theme()->publish($name);

        $this->assertIsBool($check);
        $this->assertTrue($check);
        $this->assertDirectoryExists($dist);
    }

    /**
     * Verifica se é um exception é enviado
     *
     * @return void
     */
    public function testPublishWithoutTheme()
    {
        $this->expectException(ArgumentCountError::class);

        $this->theme()->publish();
    }

    /**
     * Verifica o namespace para chamar o tema está OK
     *
     * @return void
     */
    public function testNamespace()
    {
        $theme = $this->faker->word();

        $namespace = $this->theme()->namespace($theme);

        $this->assertIsString($namespace, $theme);
    }

    /**
     * Verifica se consegue recuperar todas as
     *
     * @return void
     */
    public function testGetTheme()
    {
        $name1 = $this->faker->word();
        $name2 = $this->faker->word() . time();

        $this->theme()->create($name1);

        $theme1 = $this->theme()->get($name1);
        $theme2 = $this->theme()->get($name2);

        $this->assertInstanceOf(Theme::class, $theme1);
        $this->assertNull($theme2);
    }

    /**
     * Verifica se um tema existente é verificado corretamente
     *
     * @return void
     */
    public function testExistsTheme()
    {
        $theme = $this->faker->word();

        $this->theme()->create($theme);

        $check = $this->theme()->exists($theme);

        $this->assertTrue($check);
    }

    /**
     * Verifica se um tema NÃO existente é verificado corretamente
     *
     * @return void
     */
    public function testNotExistsTheme()
    {
        $theme = $this->faker->word() . time();
        $check = $this->theme()->exists($theme);

        $this->assertFalse($check);
    }

    /**
     * Verifica se o diretório-base para os tema
     * foi criado sim ou não
     *
     * @return boolean
     */
    public function testIsBaseExists()
    {
        $check = $this->theme()->existsBase();

        $this->assertIsBool($check);
    }

    /**
     * Verifica se retorna todas as diretivas criadas em um tema
     * e se o retorno está compátivel
     *
     * @return void
     */
    public function testGetDirectivesReturn()
    {
        $directives = $this->getDirectives();

        $this->assertIsArray($directives);

        $this->assertArrayHasKey('include', $directives);
        $this->assertArrayHasKey('component', $directives);

        $this->assertNotEmpty($directives['include']);
        $this->assertNotEmpty($directives['component']);
    }

    /**
     * Verifica se os retornos das diretivas estão vindo de maneira
     * correta e com as propriedades OK
     *
     * @return void
     */
    public function testAnalyzeDirectives()
    {
        $directives = $this->getDirectives();

        $include   = $directives['include'][0];
        $component = $directives['component'][0];

        $this->assertInstanceOf(Directive::class, $include);
        $this->assertInstanceOf(Directive::class, $component);

        $this->assertInstanceOf(Theme::class, $include->theme);
        $this->assertInstanceOf(Theme::class, $component->theme);
    }

    /**
     * Verifica se retorna todas as diretivas de um tema
     * com apenas includes dentro do tema
     *
     * @return void
     */
    public function testGetDirectiveOnlyInclude()
    {
        $theme   = $this->faker->word() . time();
        $include = $this->faker->word();

        $this->theme()->create($theme);

        $this->directive()->include($theme, $include);

        $directives = $this->theme()->directives($theme);

        $this->assertIsArray($directives);
        $this->assertArrayHasKey('include', $directives);
        $this->assertArrayHasKey('component', $directives);
        $this->assertNotEmpty($directives['include']);
        $this->assertEmpty($directives['component']);
    }

    /**
     * Função auxiliar para retornar criar e retornar todas as
     * diretivas de um tema
     *
     * @return array
     */
    private function getDirectives() : array
    {
        $theme     = $this->faker->word();
        $include   = $this->faker->word();
        $component = $this->faker->word();

        $this->theme()->create($theme);

        $this->directive()->component($theme, $component);
        $this->directive()->include($theme, $include);

        return $this->theme()->directives($theme);
    }
}
