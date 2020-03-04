<?php

namespace Maestriam\Samurai\Unit\Handlers;

use Tests\TestCase;
use Maestriam\Samurai\Traits\EnvHandling;
use Illuminate\Foundation\Testing\WithFaker;

class EnvFileHanlderTest extends TestCase
{
    use WithFaker, EnvHandling;

    /**
     * Verifica se retorna o valor de uma chave válida
     * e retorna nulo para uma chave não válida, dentro
     * do arquivo .env
     *
     * @return void
     */
    public function testGetKey()
    {
        $real = 'APP_ENV';
        $fake = 'FAKE_KEY_' . time();

        $true  = $this->env()->get($real);
        $false = $this->env()->get($fake);

        $this->assertIsString($true);
        $this->assertNotEmpty($true);
        $this->assertNull($false);
    }

    /**
     * Verifica se é possível definir uma chave dentro
     * do arquivo .env
     *
     * @return void
     */
    public function testSetKey()
    {
        $key  = 'THEME_CURRENT';
        $word = $this->faker->word();

        $this->env()->set($key, $word);

        $check = $this->env()->existsKey($key, true);
        $value = $this->env()->get($key);

        $this->assertIsInt($check);
        $this->assertEquals($word, $value);
    }


    /**
     * Verifica se existe uma chave específica dentro
     * do arquivo .env
     *
     * @return void
     */
    public function testExistTrueKey()
    {
        $key   = 'APP_ENV';
        $check = $this->env()->existsKey($key);

        $this->assertIsInt($check);
    }

    /**
     * Verifica se retorna nulo ao tentar
     * encontrar uma chave que não existe no
     * arquivo .env
     *
     * @return void
     */
    public function testExistsFakeKey()
    {
        $key   = 'FAKE_KEY_' . time();
        $check = $this->env()->existsKey($key);

        $this->assertNull($check);
    }

    /**
     * Verifica se existe o arquivo .env
     *
     * @return void
     */
    public function testFileExists()
    {
        $check = $this->env()->exists();

        $this->assertIsBool($check);
    }

    /**
     * Verifica se o conteúdo do arquivo .env está sendo
     * retornado
     *
     * @return void
     */
    public function testContentFile()
    {
        $content = $this->env()->content();

        $this->assertIsString($content);
    }
}
