<?php

namespace Maestriam\Samurai\Debug;

use Tests\TestCase;
use Maestriam\Samurai\Traits\ThemeHandling;
use Illuminate\Foundation\Testing\WithFaker;
use Maestriam\Samurai\Models\Directive;
use Maestriam\Samurai\Traits\DirectiveHandling;

class DebugTest extends TestCase
{
    //use ThemeHandling, DirectiveHandling, WithFaker;

    protected $files;

    public function testLoadDirective()
    {
        // $theme = 'witcher';
        // $path  = $this->getFileFolder();

        // $items = $this->seekDirectives($path);

        // foreach ($items as $item) {

        //     $this->separateFilename($item);

        // }

    }

    public function seekDirectives($path)
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
                $this->seekDirectives($search);
            }
        }

        return $this->files;
    }

    public function separateFilename($path)
    {
        $type   = $this->getTypeName($path);
        $folder = $this->getFolder($path);
        $theme  = $this->getThemeName($path);
        $path   = $this->getPath($path);

        $obj = New Directive();

        $obj->folder = $folder;
        $obj->type   = $type['type'];
        $obj->name   = $type['name'];
        $obj->theme  = $theme;
        $obj->path   = $path;

        dump($obj);
    }


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
