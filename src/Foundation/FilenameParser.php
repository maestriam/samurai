<?php

namespace Maestriam\Samurai\Foundation;

class FilenameParser
{
    /**
     * Undocumented function
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
     * Undocumented function
     *
     * @param string $path
     * @return object|null
     */
    public function filename(string $file) : ?object
    {        
        $name   = $this->parseOnlyName($file);
        $folder = $this->parseFolder($file);

        if (! $name) return null;

        $request = [
            'name'   => $name,
            'folder' => $folder
        ];

        return (object) $request;
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

        $name = (count($pieces) > 1) ? implode('/', $pieces) : $pieces[0];

        return (! strlen($name)) ? null : $name;
    }

    private function parseFolder(string $name)
    {
        $pieces = explode('/', $name);
        
        array_pop($pieces);

        return implode(DS, $pieces);
    }

    private function parseOnlyName(string $name)
    {
        $pieces = explode('/', $name);

        return array_pop($pieces);
    }
}
