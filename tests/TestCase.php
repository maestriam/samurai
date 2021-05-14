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
            
        ];
    }

    protected function getEnvironmentSetUp($app)
    {

        $app['config']->set('database.default', 'sqlite');
        
        $app['config']->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        $app['config']->set('Maestro:config', [
            'author' => [
                'name'  => 'Giuliano Sampaio',
                'email' => 'giuguitar@gmail.com'
            ]
        ]);

        $app['config']->set('Maestro:forge', [
            
        ]);
    }
}