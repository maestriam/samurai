<?php

namespace Maestriam\Samurai\Tests\Unit\Entities\Includer;

use Maestriam\Samurai\Entities\Theme;
use Maestriam\Samurai\Entities\Includer;

class MakeIncluderTest extends IncluderTestCase
{
    public function testMakeInclude()
    {
        $theme = new Theme('bands/van-hallen');

        $include = new Includer($theme, 'tables/table');

        $file = $include->create();

        $this->assertFileExists($file->path());
    }
}