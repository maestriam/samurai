<?php

namespace Maestriam\Samurai\Tests\Unit\Foundation\EnvHandler;

use Maestriam\Samurai\Tests\TestCase;
use Maestriam\Samurai\Foundation\EnvHandler;

class SetEnvVariableTest extends TestCase
{
    /**
     * Verifica se consegue criar um novo arquivo de configurações
     * se caso não exista no projeto.
     * Por padrão, sempre deve ser criado na raíz do projeto (base_path())
     * 
     * @return void
     */
    public function testIfCanCreateEnvFile()
    {
        $filename = config('samurai.env_file');
        $filepath = base_path($filename);

        if (file_exists($filepath)) {
            unlink($filepath);
        }

        $handler = new EnvHandler();

        $this->assertFileExists($filepath);
        $this->assertEquals($filepath, $handler->file());
    }

    /**
     * Verifica se consegue criar um novo arquivo de configuração,
     * caso não tenha um nome definido na configuração do pacote.
     * Por padrão, o nome sempre será .env e ficará na raíz do projeto
     *
     * @return void
     */
    public function testIfCanCreateEnvFileWithDefaultName()
    {
        config(['samurai.env_file' => null]);
        
        $handler = new EnvHandler();

        $this->assertFileExists($handler->file());
    }

    /**
     * Verifica se consegue definir um valor no arquivo de configurações
     * de ambiente do projeto Laravel
     *
     * @return void
     */
    public function testGetAndSetEnvVariable()
    {        
        $key = 'THEME_CURRENT';
        $val = 'bands/kix';
        
        $handler = new EnvHandler();        
        $handler->set($key, $val);

        $this->assertIsString($handler->get($key));
    }

    public function tearDown(): void
    {
        $handler = new EnvHandler();
        $handler->set('THEME_CURRENT', '');
    
        restore_error_handler();
        restore_exception_handler();

        parent::tearDown();
    }
}