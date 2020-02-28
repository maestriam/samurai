<?php

namespace Maestriam\Samurai\Foundation;

class DirectiveFinder
{
    protected $files = [];

    public function scan(string $path) : array
    {
        $items = scandir($path);

        array_shift($items);
        array_shift($items);

        foreach ($items as $k => $item) {

            $search = $path . DS . $item;

            if (is_file($search)) {
                $this->files[] = $search;
            }

            else {
                $this->scan($search);
            }
        }

        return $this->files;
    }
}
