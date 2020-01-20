<?php

namespace Maestriam\Samurai\Unit\Handlers;

use Tests\TestCase;
use Maestriam\Samurai\Models\Theme;
use Maestriam\Samurai\Traits\ThemeHandling;
use Illuminate\Foundation\Testing\WithFaker;
use Maestriam\Samurai\Models\Directive;
use Maestriam\Samurai\Traits\DirectiveHandling;

class ThemeHandlerTest extends TestCase
{
    use WithFaker, ThemeHandling, DirectiveHandling;

    /**
     * Verifica se a função para trazer o diretório base funciona
     *
     * @return void
     */
    public function testBaseFolder()
    {
        $path = $this->theme()->baseFolder();

        $this->assertIsString($path);
    }

    /**
     * Verifica se o serviço consegue criar a pasta base
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
     * diretório base
     *
     * @return void
     */
    public function testAllThemes()
    {
        $folders = $this->theme()->all();

        $this->assertIsArray($folders);
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

        $this->assertDirectoryExists($object->path);
        $this->assertDirectoryIsReadable($object->path);
        $this->assertDirectoryIsWritable($object->path);
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
     * Verifica se o diretório-base para os temas está trazendo
     * um resultado booleano
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
     * Undocumented function
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

        $this->assertAttributeInstanceOf(Theme::class, 'theme', $include);
        $this->assertAttributeInstanceOf(Theme::class, 'theme', $component);

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
