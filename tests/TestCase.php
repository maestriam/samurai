<?php

namespace Maestriam\Samurai\Tests;

use Illuminate\Foundation\Application;
use Orchestra\Testbench\TestCase as BaseTestCase;
use Maestriam\FileSystem\Providers\FileSystemProvider;
use Maestriam\FileSystem\Support\FileSystem;
use Maestriam\Samurai\Entities\Theme;
use Maestriam\Samurai\Providers\SamuraiServiceProvider;

class TestCase extends BaseTestCase
{
    /**
     * {@inheritDoc}
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->initSandBox();
    }

    /**
     * {@inheritDoc}
     */
    public function tearDown() : void
    {
        $this->clearSandBox();
        parent::tearDown();
    }

    /**
     * {@inheritDoc}
     */
    protected function getPackageProviders($app): array
    {
        return [
            FileSystemProvider::class,
            // SamuraiServiceProvider::class
        ];
    }

    /**
     * {@inheritDoc}
     */
    protected function getEnvironmentSetUp($app)
    {
        $this->registerLaravelConfig($app);

        $app['config']->set('samurai', [

            'prefix'        => 'samurai-theme',
            'env_key'       => 'THEME_CURRENT',
            'env_file'      => '.env.testing',
            'publishable'   => 'assets',
            'description'   => 'A new awsome theme is comming!',
            'template_path' => __DIR__ . '/../stubs/',

            'species' => [
                'component', 'include'
            ],

            'themes' => [
                'files'     => 'src',
                'assets'    => 'assets',
                'folder'    => __DIR__ . '/../sandbox',
            ],

            'author' => [
                'name'   => 'Giuliano Sampaio',
                'vendor' => 'maestriam',
                'email'  => 'giuguitar@gmail.com',
            ],

            'structure' => [
                'composer'  => '.', 
                'include'   => 'src/',
                'component' => 'src/',
            ]
        ]);
    }

    /**
     * Verifica se classe possui determinada função
     *
     * @param mixed $obj
     * @param string $function
     * @return void
     */
    protected function assertObjectHasFunction($obj, string $function)
    {
        $exists = method_exists($obj, $function);

        $this->assertTrue($exists);
    }

    /**
     * Cria um novo diretório para testes
     *
     * @return void
     */
    protected function initSandBox()
    {
        $sandbox = config('samurai.themes.folder');

        FileSystem::folder($sandbox)->create();
    }

    /**
     * Retorna a instância de um tema
     *
     * @param string $package
     * @return Theme
     */
    protected function theme(string $package) : Theme
    {
        return new Theme($package);
    }

    /**
     * Remove o diretório de conteúdo de testes
     *
     * @return void
     */
    protected function clearSandBox($folder = null)
    {
        $sandbox = $folder ?? config('samurai.themes.folder');

        $files = array_diff(scandir($sandbox), array('.', '..'));

        foreach ($files as $file) { 

            $item = "$sandbox/$file";

            is_dir($item) ? $this->clearSandBox($item) : unlink($item); 
        }

        return rmdir($sandbox);
    }


    /**
     * Registra as configurações do Laravel para o pacote.
     *
     * @param Application $app
     * @return void
     */
    private function registerLaravelConfig(Application $app)
    {
        $app['config']->set('view', [
            'compiled' => storage_path('framework/views'),
            'paths'    => [resource_path('views')]
        ]);
    }
}
