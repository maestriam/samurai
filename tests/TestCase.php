<?php

namespace Maestriam\Samurai\Tests;

use Orchestra\Testbench\TestCase as BaseTestCase;
use Maestriam\FileSystem\Providers\FileSystemProvider;
use Maestriam\Samurai\Providers\SamuraiServiceProvider;

class TestCase extends BaseTestCase
{
    /**
     * {@inheritDoc}
     */
    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * Retorna o Service Provider para carregamento
     *
     * @param mixed $app
     * @return array
     */
    protected function getPackageProviders($app): array
    {
        return [
            FileSystemProvider::class,
            // SamuraiServiceProvider::class
        ];
    }

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
                'composer'    => '.', 
                '*-include'   => 'src/',
                '*-component' => 'src/',
            ]
        ]);
    }

    private function registerLaravelConfig($app)
    {
        $app['config']->set('view', [
            'compiled' => storage_path('framework/views'),
            'paths'    => [resource_path('views')]
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
}
