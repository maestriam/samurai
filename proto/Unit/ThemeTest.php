<?php

namespace Maestriam\Samurai\Tests;

use Illuminate\Support\Facades\Config;
use Tests\TestCase;
use Maestriam\Samurai\Traits\ThemeHandling;

class ThemeTest extends TestCase
{
    use ThemeHandling;

    public function testCreateTheme()
    {
        $name = 'rivia';

        $theme = $this->theme($name)->build();
    }

    public function testFindOrCreate()
    {
        $name = 'novigrad';

        $theme = $this->theme($name)->findOrCreate();
    }

    // public function testDirectives()
    // {
    //     $name = 'skellige';

    //     $directives = $this->theme($name)->directives();
    // }
}
