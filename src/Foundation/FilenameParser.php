<?php

namespace Maestriam\Samurai\Foundation;

class FilenameParser
{

    private function getTypeName($path)
    {
        $pieces = explode(DS, $path);

        $filename = array_pop($pieces);
        $filename = str_replace('.blade.php', '', $filename);

        $name = explode('-', $filename);

        return [
            'name' => $name[0],
            'type' => $name[1],
        ];
    }


    public function getFolder($path)
    {
        $base = $this->getFileFolder();

        $path = str_replace($base, '', $path);
        $path = explode(DS, $path);

        array_splice($path, -2);

        return implode(DS, $path);
    }

    public function getThemeName($path)
    {
        $base = base_path('themes') . DS;

        $path = str_replace($base, '', $path);

        $pieces = explode(DS, $path);

        return array_shift($pieces);
    }

    public function getFileFolder()
    {
        return base_path('themes/witcher/src');
    }

    public function getPath($path)
    {
        $pieces = explode(DS, $path);

        array_splice($pieces, -1);

        return implode(DS, $pieces);
    }
}
