<?php

namespace Maestriam\Samurai\Tests\Unit\Entities\Theme;

use Maestriam\Samurai\Tests\TestCase;
use Maestriam\Samurai\Entities\Includer;

class CreateIncluderTest extends TestCase
{
    public function testImportInclude()
    {
        $theme = $this->theme('bands/great-white')->make();

        $include = $theme->include('musics/stick-it')->create();

        $this->assertInstanceOf(Includer::class, $include);
    }
}