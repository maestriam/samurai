<?php

namespace Maestriam\Samurai\Providers;

use Blade;
use Config;
use Illuminate\Support\ServiceProvider;
use Maestriam\Samurai\Console\UseThemeCommand;
use Maestriam\Samurai\Console\MakeThemeCommand;
use Maestriam\Samurai\Console\MakeIncludeCommand;
use Maestriam\Samurai\Console\PublishThemeCommand;
use Maestriam\Samurai\Console\MakeComponentCommand;
use Maestriam\Samurai\Console\RefreshThemeCommand;
use Maestriam\Samurai\Console\InitThemeCommand;

class MainServiceProvider extends ServiceProvider
{
    /**
     * Ao iniciar o service provider...
     *
     * @return void
     */
    public function boot()
    {
        $this->registerErrors();
        $this->registerConfigs();
        $this->registerConstants();
        $this->registerTranslations();
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
        $source    = __DIR__.'/../config/config.php';
        $published = config_path('samurai.php');

        $this->publishes([$source => $published], 'Samurai');

        $config = (is_file($published)) ? $published : $source; 
        $this->mergeConfigFrom($config, 'Samurai');

        $file = __DIR__.'/../Config/consts.php';
        $this->mergeConfigFrom($file, 'Samurai.consts');

    }

    /**
     * Define todas as constantes que auxiliarão
     * dentro da aplicação
     *
     * @return void
     */
    protected function registerConstants()
    {
        $consts = Config::get('Samurai.consts');

        foreach ($consts as $k => $v) {
    
            if (defined($k)) {
                return false;
            }
        
            define($k, $v);
        }
    }


    protected function registerErrors()
    {
        $file = __DIR__.'/../Config/errors.php';
        $this->mergeConfigFrom($file, 'Samurai.errors');

        $consts = Config::get('Samurai.errors');

        foreach ($consts as $code => $prop) {

            $const = $prop['const'];

            if (defined($const)) {
                return false;
            }

            define($const, $code);
        }
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
        $this->app->register(RegistersThemesServiceProvider::class);
        $this->app->register(LoadThemesServiceProvider::class);
        $this->app->register(RegistersCustomDirectiveProvider::class);
    }
}
