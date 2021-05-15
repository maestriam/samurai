<?php

namespace Maestriam\Samurai\Tests;

use Maestriam\Samurai\Providers\SamuraiServiceProvider;
use Orchestra\Testbench\TestCase as BaseTesCase;

class TestCase extends BaseTesCase
{
    /**
     * {@inheritDoc}
     */
    public function setUp() : void
    {
        parent::setUp();
    }

    /**
     * Retorna o Service Provider para carregamento
     *
     * @param mixed $app
     * @return array
     */
    protected function getPackageProviders($app) : array
    {
        return [
            SamuraiServiceProvider::class
        ];
    }

    protected function getEnvironmentSetUp($app)
    {             
        $this->registerLaravelConfig($app);

        $app['config']->set('samurai', [
            'prefix'  => 'samurai-theme',
            'species' => [
                'component', 'include'
            ],
            'themes' => [
                'files'     => 'src',
                'assets'    => 'assets',
                'folder'    => base_path('themes'),
            ],
            'author' => [
                'name'   => 'Giuliano Sampaio',
                'vendor' => 'maestriam',
                'email'  => 'giuguitar@gmail.com',
            ],
            'publishable' => 'assets',
            'env_file'    => '.env.testing',
            'env_key'     => 'THEME_CURRENT',
            'description' => 'A new awsome theme is comming!',
        ]);
    }

    private function registerLaravelConfig($app)
    {
        $app['config']->set('view', [
            'compiled' => storage_path('framework/views')
        ]);
    }
}