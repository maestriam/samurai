<?php

namespace Maestriam\Samurai\Console;

use Exception;
use Illuminate\Console\Command;
use Maestriam\Samurai\Traits\BasicConfig;
use Maestriam\Samurai\Traits\ThemeHandling;

class CreateThemeCommand extends Command
{
    /**
     * Propriedades e funções básicas do sistema
     */
    use BasicConfig, ThemeHandling;

    /**
     * Caminho onde será armazenados os temas
     *
     * @var string
     */
    protected $themePath = '';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = '';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new katana-based theme.';

    /**
     * Define as propriedades principais do pacote
     *
     * @return void
     */
    public function __construct()
    {
        $this->signature = $this->getSignature();
        $this->themePath = $this->getThemeConfig('themes.folder');

        parent::__construct();
    }

    /**
     * Retorna a assinatua do comando Artisan
     *
     * @return string
     */
    protected function getSignature()
    {
        $sign = ':make-theme {name}';

        return $this->commandAlias . $sign;
    }

    /**
     * Executa o comando de console
     *
     * @return mixed
     */
    public function handle()
    {
        if (! $this->isBaseThemeFolder()) {
            $this->createBaseThemeFolder();
        }

        $name = $this->argument('name');

        if ($this->themeExists($name)) {
            return $this->info(__('katana::console.theme.exists'));
        }

        $this->createTheme($name);
    }

    /**
     * Cria os diretórios e estrutura do template
     *
     * @return void
     */
    protected function createTheme($name)
    {
        $this->info('Criando tema ' . $name. '...');
        $dir = $this->themePath . DS . $name;

        mkdir($dir, $this->permissionLevel);

        $this->createSubFolders($dir);
        $this->info(__('katana::console.theme.created'));
    }

    /**
     * Cria os subdiretórios do tema de acordo
     * com as definições vindo do arquivo de configuração
     *
     * @param string $folder
     * @return void
     */
    protected function createSubFolders($folder)
    {
        $subfolders = $this->getThemeConfig('themes.structure');

        foreach ($subfolders as $type => $sub) {

            $sub = str_replace("/", DS, $sub);
            $sub = $folder . DS . $sub;

            $param =  ['folder' => $sub];

            $this->info(__('katana::console.theme.subdir', $param));

            mkdir($sub, $this->permissionLevel, true);
        }
    }

    /**
     * Cria o diretório para armazenamento de temas
     *
     * @return boolean
     */
    protected function createBaseThemeFolder()
    {
        try {
            mkdir($this->themePath);
            return true;

        } catch (Exception $e) {
            return false;
        }
    }
}
