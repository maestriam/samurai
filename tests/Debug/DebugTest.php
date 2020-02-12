<?php

namespace Maestriam\Samurai\Debug;

use Tests\TestCase;
use Maestriam\Samurai\Traits\ThemeHandling;
use Illuminate\Foundation\Testing\WithFaker;
use Maestriam\Samurai\Traits\DirectiveHandling;

class DebugTest extends TestCase
{
    use ThemeHandling, DirectiveHandling, WithFaker;

    protected $files;

    public function testLoadDirective()
    {
        dump('Inicio...');
        $path = base_path('themes/ollaf/src');

        $items[] = $this->seekDirectives($path);

        dump('Resultado');
        dd($items);

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

    // public function getDirContents($dir, &$results = array()){

    //     $files = scandir($dir);
    //     array_shift($files);
    //     array_shift($files);

    //     foreach($files as $key => $value){
    //         $path = realpath($dir.DIRECTORY_SEPARATOR.$value);
    //         dump($path);
    //         if(! is_dir($path)) {
    //             $results[] = $path;
    //         } else if($value != "." && $value != "..") {
    //             $this->getDirContents($path, $results);
    //             //$results[] = $path;
    //         }
    //     }

    //     dump('terminando...');

    //     return $results;
    // }
}
