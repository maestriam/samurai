<?php

namespace Maestriam\Samurai\Traits\Theme;

use Maestriam\Samurai\Models\Theme;
use Maestriam\Samurai\Exceptions\InvalidThemeNameException;

/**
 * Funcionalidades de acessórios(getters/setters)
 * para definição de vendor, classe Models/Theme
 */
trait Accessors
{
    /**
     * Define o vendor que servirá para criação
     * do arquivo composer.json, como para o nome do tema
     *
     * @return Theme
     */
    public final function setVendor(string $vendor)
    {
        if (! $this->valid()->vendor($vendor)) {
            throw new InvalidThemeNameException($vendor);
        }

        $this->vendor = $vendor;
        return $this;
    }

    /**
     * Interpreta as informações vindas do vendor e
     * define o nome, caminho, namespace e distribuidor do tema
     *
     * @return void
     */
    public final function parseVendor()
    {
        if (! $this->vendor) {
            throw new InvalidThemeNameException($this->vendor);
        }

        $vendor = $this->parser()->vendor($this->vendor);

        $this->setName($vendor->name)
             ->setDistributor($vendor->distributor)
             ->setNamespace($vendor->name)
             ->setPath($vendor->distributor, $vendor->name);
    }

    /**
     * Define o nome do autor do tema
     * Usado no arquivo composer.json
     *
     * @param string $author
     * @return void
     */
    public function author(string $author)
    {
        if (! $this->valid()->author($author)) {
            dump($this->valid()->author($author));
            dump($author);
            throw new InvalidThemeNameException($author);
        }

        $this->author = $author;
        return $this;
    }

    /**
     * Define a descrição do tema
     * Usado no arquivo composer.json
     *
     * @param string $author
     * @return void
     */
    public function description(string $description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * Retorna a URL de assets do tema dentro
     * do projeto Laravel
     *
     * @return string
     */
    public function public() : string
    {
        $url = 'themes/' . $this->vendor;
        return asset($url);
    }

    /**
     * Retorna o caminho do diretório onde são armazenados
     * os arquivos de diretivas (include/component)
     *
     * @return string
     */
    public function filePath() : string
    {
        $dist = $this->distributor;
        return $this->dir()->files($dist, $this->name);
    }

    /**
     * Retorna o caminho público do projeto
     * onde os asses do projeto são armazenados
     *
     * @return string
     */
    public function publicPath() : string
    {
        return $this->dir()->public($this->name);
    }

    /**
     * Retorna o caminho do diretório onde são armazenados
     * os arquivos de assets (js/css/imgs)
     *
     * @return string
     */
    public function assetPath() : string
    {
        $dist = $this->distributor;
        return $this->dir()->assets($dist, $this->name);
    }

    /**
     * Define o nome do tema que será criado/manipulado
     *
     * @param string $name
     * @return $this
     */
    private final function setName(string $name)
    {
        if (! $this->isValidName($name)) {
            throw new InvalidThemeNameException($name);
        }

        $this->name = strtolower($name);
        return $this;
    }

    /**
     * Define o nome do tema que será criado/manipulado
     *
     * @param string $name
     * @return $this
     */
    private final function setDistributor(string $dist)
    {
        if (! $this->isValidName($dist)) {
            throw new InvalidThemeNameException($dist);
        }

        $this->distributor = strtolower($dist);
        return $this;
    }

   /**
     * Define o caminho-base do tema
     *
     * @param string $name
     * @return void
     */
    private final function setPath(string $dist, string $name)
    {
        $this->path = $this->dir()->theme($dist, $name);
        return $this;
    }

    /**
     * Define o "apelido" do tema para ser chamado no projeto
     *
     * @param string $name
     * @return void
     */
    private final function setNamespace(string $name)
    {
        $this->namespace = $this->nominator()->namespace($name);
        return $this;
    }

    /**
     * Retorna o nome e e-mail do autor definido para o tema.
     * Se não for encontrado um valor específico, retorna o valor
     * padrão definido no arquivo de configuração
     *
     * @return object
     */
    private final function getAuthor() : object
    {
        if (! $this->author) {
            return $this->config()->author();
        }

        return $this->parser()->author($this->author);
    }

    /**
     * Retorna a descrição definido para o tema.
     * Se não for encontrado um autor específico, retorna o autor
     * padrão definido no arquivo de configuração
     *
     * @return object
     */
    private final function getDescription() : string
    {
        if (! $this->description) {
            return $this->config()->description();
        }

        return $this->description;
    }
}
