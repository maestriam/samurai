<?php

namespace Maestriam\Samurai\Providers;

use Blade;
use Illuminate\Support\ServiceProvider;
use Maestriam\Samurai\Console\UseThemeCommand;
use Maestriam\Samurai\Console\MakeThemeCommand;
use Maestriam\Samurai\Console\MakeIncludeCommand;
use Maestriam\Samurai\Console\PublishThemeCommand;
use Maestriam\Samurai\Console\MakeComponentCommand;
use Maestriam\Samurai\Console\RefreshThemeCommand;

class MainServiceProvider extends ServiceProvider
{
    /**
     * Ao iniciar o service provider...
     *
     * @return void
     */
    public function boot()
    {
        $this->registerTranslations();
        $this->registerConstants();
        $this->registerConfigs();
        $this->registerCommands();
        $this->registerServices();

    }

    /**
     * Define as traduções e mensagens do pacote
     *
     * @return void
     */
    public function registerTranslations()
    {
        $alias    = 'Samurai';
        $basePath = 'resources/lang/vendor/';

        $langPath = base_path($basePath) . $alias;
        $dirPath  = __DIR__ .'/../Resources/lang';

        if (is_dir($langPath)) {
            return $this->loadTranslationsFrom($langPath, $alias);
        }

        $this->loadTranslationsFrom($dirPath, $alias);
    }


    /**
     * Registra todos os arquivos de configurações do componente
     *
     * @return void
     */
    protected function registerConfigs()
    {
        $dir = __DIR__.'/../Config/config.php';

        $this->mergeConfigFrom($dir, 'Samurai');
    }

    /**
     * Define todas as constantes que auxiliarão
     * dentro da aplicação
     *
     * @return void
     */
    protected function registerConstants()
    {
        if ( defined('DS')) {
            return false;
        }

        define('DS', DIRECTORY_SEPARATOR);
    }

    /**
     * Registra todos os comandos artisans do Maestriam Samurai
     *
     * @return void
     */
    protected function registerCommands()
    {
        $cmds = [
            MakeThemeCommand::class,
            MakeComponentCommand::class,
            MakeIncludeCommand::class,
            PublishThemeCommand::class,
            UseThemeCommand::class,
            RefreshThemeCommand::class,
        ];

        $this->commands($cmds);
    }

    /**
     * Registra todos os serviços que devem ser iniciados
     * junto com o pacote
     *
     * @return void
     */
    protected function registerServices()
    {
        $this->app->register(RegistersThemesServiceProvider::class);
        $this->app->register(LoadThemesServiceProvider::class);
        $this->app->register(RegistersCustomDirectiveProvider::class);
    }
}
