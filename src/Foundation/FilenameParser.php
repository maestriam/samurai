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
    public function file(string $themepath, string $filepath) : object
    {
        $type = $this->parseType($filepath);
        $name = $this->parseName($themepath, $filepath);

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
     * @return array
     */
    private function parseType(string $path) : string
    {
        $pieces = explode(DS, $path);

        $filename = array_pop($pieces);
        $filename = str_replace('.blade.php', '', $filename);

        $name = explode('-', $filename);
        $type = $name[1] ?? null;

        return $type;
    }

    /**
     * Undocumented function
     *
     * @param string $theme
     * @param string $path
     * @return string|null
     */
    public function parseName(string $theme, string $path) : ?string
    {
        $theme  = str_replace($theme . DS, '', $path);
        $pieces = explode(DS, $theme);

        array_pop($pieces);

        $name = implode(DS, $pieces);

        return (! strlen($name)) ? null : $name;
    }
}
