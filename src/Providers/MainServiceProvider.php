<?php

namespace Maestriam\Katana;

use Config;
use Illuminate\Support\ServiceProvider;
use Maestriam\Katana\Traits\BasicConfig;
use Maestriam\Katana\Traits\ThemeHandling;
use Maestriam\Katana\Services\ThemeLoader;
use Maestriam\Katana\Console\CreateThemeCommand;
use Maestriam\Katana\Console\CreateComponentCommand;
use Maestriam\Katana\Console\CreateIncludeCommand;

class MainServiceProvider extends ServiceProvider
{
    /**
     * Trait com as propriedades gerais do pacote
     */
    use BasicConfig;

    /**
     * Trait com as funções gerais de tema
     */
    use ThemeHandling;

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
        $this->registerThemes();
        $this->loadDefaultTheme();
    }

    /**
     * Define as traduções e mensagens do pacote
     *
     * @return void
     */
    public function registerTranslations()
    {
        $alias    = $this->commandAlias;
        $basePath = 'resources/lang/vendor/';

        $langPath = base_path($basePath) . $alias;
        $dirPath  = __DIR__ .'/../Resources/lang';

        if (is_dir($langPath)) {
            return $this->loadTranslationsFrom($langPath, $alias);
        }

        $this->loadTranslationsFrom($dirPath, $alias);
    }

    /**
     * Define todas as constantes que auxiliarão
     * dentro da aplicação
     *
     * @return void
     */
    protected function registerConstants()
    {
        define('DS', DIRECTORY_SEPARATOR);
    }

    /**
     * Registra todos os comandos artisans do Maestriam Katana
     *
     * @return void
     */
    protected function registerCommands()
    {
        $cmds = [
            CreateThemeCommand::class,
            CreateComponentCommand::class,
            CreateIncludeCommand::class,
        ];

        $this->commands($cmds);
    }

    /**
     *
     *
     * @return void
     */
    protected function loadDefaultTheme()
    {
        $loader = new ThemeLoader();

        $loader->load();
    }

    /**
     * Registra todos os arquivos de configurações do componente
     *
     * @return void
     */
    protected function registerConfigs()
    {
        $dir = __DIR__.'/../Config/config.php';

        $this->mergeConfigFrom($dir, $this->configAlias);
    }

    /**
     * Percorre todos os temas para registrar os caminhos
     * dos temas para serem monitorados pelo Laravel.
     *
     * @return void
     */
    protected function registerThemes()
    {
        $dir    = $this->getThemeConfig('themes.folder');
        $themes = $this->getAllThemes();

        if (empty($themes)) {
            return false;
        }

        foreach ($themes as $theme) {

            $namespace = $this->theme()->namespace($theme);
            $source    = $dir . DS . $theme;

            $this->registerView($source, $namespace);
        }

        return true;
    }

    /**
     * Registra um caminho como parte da base de views
     * do Laravel
     *
     * @param string $source
     * @param string $namespace
     * @return void
     */
    protected function registerView($source, $namespace)
    {
        $views = array_merge([$source], Config::get('view.paths'));

        $this->loadViewsFrom($views, $namespace);
    }
}
