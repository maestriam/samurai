<?php

namespace Maestriam\Samurai\Tests;

use Illuminate\Foundation\Application;
use Orchestra\Testbench\TestCase as BaseTestCase;
use Maestriam\FileSystem\Providers\FileSystemProvider;
use Maestriam\FileSystem\Support\FileSystem;
use Maestriam\Samurai\Entities\Component;
use Maestriam\Samurai\Entities\Includer;
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
            SamuraiServiceProvider::class
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
            'publishable'   => 'themes',
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
                'name'  => 'Giuliano Sampaio',
                'dist'  => 'maestriam',
                'email' => 'giuguitar@gmail.com',
            ],

            'structure' => [
                'composer'  => '.', 
                'include'   => 'src/',
                'component' => 'src/',
            ]
        ]);
    }

    /**
     * Afirma que a classe possui determinada função
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
     * Afirma se a váriavel se trata de uma instância Theme válida.  
     *
     * @param mixed $theme
     * @return void
     */    
    protected function assertValidTheme($theme)
    {
        $this->assertInstanceOf(Theme::class, $theme);
        $this->assertTrue($theme->exists());
    }

    /**
     * Afirma se a váriavel se trata de uma instância Component válida.  
     *
     * @param mixed $component
     * @return void
     */
    protected function assertValidComponent($component)
    {
        $this->assertInstanceOf(Component::class, $component);
    }

    /**
     * Afirma se a váriavel se trata de uma instância Includer válida.  
     *
     * @param mixed $includer
     * @return void
     */
    protected function assertValidIncluder($includer)
    {
        $this->assertInstanceOf(Includer::class, $includer);
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
        $sandbox = config('samurai.themes.folder');

        FileSystem::folder($sandbox)->delete();
    }

    /**
     * Registra as configurações do Laravel para o pacote.
     *
     * @param Application $app
     * @return void
     */
    protected function registerLaravelConfig(Application $app)
    {
        $app['config']->set('view', [
            'compiled' => storage_path('framework/views'),
            'paths'    => [resource_path('views')]
        ]);
    }
}
