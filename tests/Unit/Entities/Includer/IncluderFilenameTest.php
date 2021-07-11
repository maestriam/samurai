<?php

namespace Maestriam\Samurai\Tests\Unit\Entities\Includer;

use Maestriam\Samurai\Entities\Includer;
use Maestriam\Samurai\Tests\TestCase;

class IncluderFilenameTest extends IncluderTestCase
{
    public function testFilename()
    {
        $theme = $this->theme('bands/santana')->make();

        $expected = 'button-include.blade.php';
        $includer = $theme->include('button');

        $this->assertEquals($expected, $includer->filename());
    }
}