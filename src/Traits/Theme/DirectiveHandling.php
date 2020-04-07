<?php

namespace Maestriam\Samurai\Traits\Theme;

use Maestriam\Samurai\Models\Directive;
use Maestriam\Samurai\Exceptions\ThemeNotFoundException;

trait DirectiveHandling
{
    /**
     * Retorna TODAS as diretivas cadastradas
     * dentro de um tema
     *
     * @return array
     */
    public final function directives() : array
    {
        $files = $this->scan();

        if (empty($files)) return [];

        $collection = [];

        foreach($files as $path) {

            $request = $this->parseFilePath($path);

            if ($request == null) continue;

            $obj = $this->directivefy($request->name, $request->type);

            $collection[] = $obj;
        }

        return $collection;
    }

    /**
     * Retorna a instância de uma include para
     * um determinado tema
     *
     * @param string $name
     * @return Directive
     */
    public function include(string $name) : Directive
    {
        if (! $this->exists()) {
            throw new ThemeNotFoundException($this->name);
        }

        return $this->directivefy($name, 'include');
    }

    /**
     * Undocumented function
     *
     * @param string $name
     * @return Directive
     */
    public function component(string $name) : Directive
    {
        if (! $this->exists()) {
            throw new ThemeNotFoundException($this->name);
        }

        return $this->directivefy($name, 'component');
    }

    /**
     * Identifica o nome e o tipo da diretiva através
     * de seu caminho absoluto
     *
     * @param string $file
     * @return object|null
     */
    private final function parseFilePath(string $file) : ?object
    {
        $path = $this->filePath();

        return $this->parser()->file($path, $file);
    }

    /**
     * Carrega todas as diretivas de um tema para
     * ser usado dentro do projeto
     *
     * @return void
     */
    public function load()
    {
        $directives = $this->directives();

        if (empty($directives)) return true;

        foreach($directives as $directive) {
            $directive->load();
        }

        return true;
    }

}
