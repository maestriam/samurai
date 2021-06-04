<?php

namespace Maestriam\Samurai\Providers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;
use Maestriam\Samurai\Console\UseThemeCommand;
use Maestriam\Samurai\Console\MakeThemeCommand;
use Maestriam\Samurai\Console\MakeIncludeCommand;
use Maestriam\Samurai\Console\PublishThemeCommand;
use Maestriam\Samurai\Console\MakeComponentCommand;
use Maestriam\Samurai\Console\RefreshThemeCommand;
use Maestriam\Samurai\Console\InitThemeCommand;
use Maestriam\Samurai\Entities\Samurai;

class SamuraiServiceProvider extends ServiceProvider
{
    /**
     * Ao iniciar o service provider...
     *
     * @return void
     */
    public function boot()
    {
        $this->registerConfigs();
        $this->registerFacade();
        $this->registerCommands();
        $this->registerServices();
    }

    private function registerFacade()
    {
        $this->app->bind('samurai',function() {
            return new Samurai();
        });
    }


    /**
     * Registra todos os arquivos de configurações do componente
     *
     * @return void
     */
    protected function registerConfigs()
    {
        $source    = __DIR__.'/../Config/config.php';
        $published = config_path('samurai.php');

        $this->publishes([$source => $published], 'samurai');

        $config = (is_file($published)) ? $published : $source; 
        $this->mergeConfigFrom($config, 'samurai');
    }

    /**
     * Registra todos os comandos artisans do Maestriam Samurai
     *
     * @return void
     */
    protected function registerCommands()
    {
        $cmds = [
            InitThemeCommand::class,
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
        // $this->app->register(RegistersThemesServiceProvider::class);
        // $this->app->register(LoadThemesServiceProvider::class);
        // $this->app->register(RegistersCustomDirectiveProvider::class);
    }
}
