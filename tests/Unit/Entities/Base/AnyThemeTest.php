<?php

namespace Maestriam\Samurai\Tests\Unit\Entities\Base;

use Maestriam\Samurai\Entities\Base;
use Maestriam\Samurai\Tests\TestCase;

class AnyThemeTest extends TestCase
{
    public function testFindAnyThemeWithinFullDir()
    {   
        $this->theme('bands/hardline')->findOrCreate();

        $base = new Base();

        $any = $base->any();

        $this->assertValidTheme($any);
    }    

    public function testFindAnyThemeWithinEmptyDir()
    {
        $base = new Base();

        $any = $base->any();

        $this->assertNull($any);
    }

    public function testFindCurrentTheme()
    {
        $this->theme('bands/hardline')->findOrCreate()->use();

        $base = new Base();

        $any = $base->any();

        $this->assertValidTheme($any);
    }
}