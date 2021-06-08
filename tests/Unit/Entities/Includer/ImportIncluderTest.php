<?php

namespace Maestriam\Samurai\Tests\Unit\Entities\Includer;

use Maestriam\Samurai\Entities\Includer;
use Maestriam\Samurai\Tests\TestCase;

class ImportIncluderTest extends TestCase
{
    public function testImportInclude()
    {
        $theme = $this->theme('bands/great-white')->findOrCreate();

        $include = $theme->include('musics/stick-it')->create();

        $ret = $include->import();

        $this->assertInstanceOf(Includer::class, $ret);
    }
}