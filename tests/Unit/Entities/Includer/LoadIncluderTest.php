<?php

namespace Maestriam\Samurai\Tests\Unit\Entities\Includer;

use Maestriam\Samurai\Entities\Includer;
use Maestriam\Samurai\Tests\TestCase;

class LoadIncluderTest extends TestCase
{
    public function testLoadInclude()
    {
        $theme = $this->theme('bands/great-white')->findOrCreate();

        $include = $theme->include('musics/stick-it')->create();

        $ret = $include->load();

        $this->assertInstanceOf(Includer::class, $ret);
    }
}