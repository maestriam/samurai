<?php

namespace Maestriam\Samurai\Tests\Unit\Entities\Includer;

use Maestriam\Samurai\Entities\Includer;
use Maestriam\Samurai\Exceptions\DirectiveExistsException;

class CreateIncluderTest extends IncluderTestCase
{
    public function testMakeInclude()
    {
        $theme = $this->theme('bands/van-hallen');

        $include = new Includer($theme, 'tables/table');

        $file = $include->create();

        $this->assertFileExists($file->path());
    }

    public function testExistingIncluder()
    {
        $theme = $this->theme('bands/van-hallen');

        $include1 = new Includer($theme, 'tables/table');
        $include2 = new Includer($theme, 'tables/table');

        $this->expectException(DirectiveExistsException::class);

        $include1->create();
        $include2->create();
    }
}