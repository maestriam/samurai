<?php

namespace Maestriam\Samurai\Foundation;

class FilenameParser
{
    /**
     * Baseado no caminho do arquivo, retorna o nome e o tipo da diretiva
     *
     * @param string $themepath
     * @param string $filepath
     * @return object
     */
    public function file(string $themepath, string $filepath) : ?object
    {
        $file = $this->parserFilename($themepath, $filepath);
        $type = $this->parseType($file);
        $name = $this->parseFullName($file);

        if (! $name || ! $type) return null;

        $request = [
            'name' => $name,
            'type' => $type
        ];

        return (object) $request;
    }

    /**
     * Retorna o nome do arquivo e seu diretório,
     * dado seu caminho dentro do sistema
     *
     * @param string $path
     * @return object|null
     */
    public function filename(string $file) : ?object
    {
        $name   = $this->parseOnlyName($file);
        $folder = $this->parseFolder($file);
        
        if (! $name) {
           return null;
        }
        
        return (object) ['name' => $name, 'folder' => $folder];
    }

    /**
     * Interpreta a resposta do usuário para pegar
     * o e-mail e nome do autor
     *
     * @param string $author
     * @return object
     */
    public function author(string $author) : object
    {
        $pieces = explode(' <', $author);

        $obj = [
            'name'  => $pieces[0],
            'email' => str_replace('>', '', $pieces[1]),
        ];

        return (object) $obj;
    }

    /**
     * Undocumented function
     *
     * @param string $vendor
     * @return object
     */
    public function vendor(string $vendor) : object
    {
        $pieces = explode('/', $vendor);

        return (object) [
            'distributor' => $pieces[0],
            'name'        => $pieces[1]
        ];
    }

    /**
     * Retorna apenas o nome do arquivo da diretiva
     * Sem o caminho do tema a qual pertence
     *
     * @param string $theme
     * @param string $path
     * @return string
     */
    private function parserFilename(string $theme, string $path) : string
    {
        return str_replace($theme . DS, '', $path);
    }

    /**
     * Undocumented function
     *
     * @param string $path
     * @return array
     */
    private function parseType(string $path) : string
    {
        $pieces = explode(DS, $path);

        $filename = array_pop($pieces);
        $filename = str_replace('.blade.php', '', $filename);

        $name = explode('-', $filename);
        $type = end($name) ?? null;

        return $type;
    }

    /**
     * Undocumented function
     *
     * @param string $theme
     * @param string $path
     * @return string|null
     */
    private function parseFullName(string $path) : ?string
    {
        $pieces = explode(DS, $path);

        $name = array_pop($pieces);

        if (empty($pieces)) {
            return $name;
        }

        $name = (count($pieces) > 1) ? implode(DS, $pieces) : $pieces[0];

        return (! strlen($name)) ? null : $name;
    }

    /**
     * Undocumented function
     *
     * @param string $name
     * @return void
     */
    private function parseFolder(string $name)
    {
        $pieces = explode('/', $name);

        array_pop($pieces);

        return implode(DS, $pieces);
    }

    /**
     * Undocumented function
     *
     * @param string $name
     * @return void
     */
    private function parseOnlyName(string $name)
    {
        $pieces = explode('/', $name);

        return array_pop($pieces);
    }
}
