<?php

namespace Maestriam\Samurai\Tests\Unit\Entities\Include;

use Maestriam\Samurai\Entities\Theme;
use Maestriam\Samurai\Tests\TestCase;
use Maestriam\Samurai\Entities\IncludeDirective;

class MakeIncludeTest extends TestCase
{
    public function testMakeInclude()
    {
        $theme = new Theme('bands/van-hallen');

        $include = new IncludeDirective($theme, 'tables/table');

        $include->make();
    }
}