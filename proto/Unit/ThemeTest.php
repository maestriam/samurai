<?php

namespace Maestriam\Samurai\Tests;

use Illuminate\Support\Facades\Config;
use Tests\TestCase;
use Maestriam\Samurai\Traits\Themeable;

class ThemeTest extends TestCase
{
    use Themeable;

    public function testCreateTheme()
    {
        $name = 'rivia';

        // $theme = $this->theme($name)->build();
    }

    public function testFindOrCreate()
    {
        $theme = 'rivia';
        $name  = 'geralt';

        //$directives = $this->theme($theme)->directives();

        //$directives[0]->load();

        //$theme = $this->theme($theme)->include($name)->create();
    }

    // public function testDirectives()
    // {
    //     $name = 'skellige';

    //     $directives = $this->theme($name)->directives();
    // }
}
