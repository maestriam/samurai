<?php

namespace Maestriam\Samurai\Tests\Unit\Entities\Base;

use Maestriam\Samurai\Entities\Base;
use Maestriam\Samurai\Tests\TestCase;

class EmptyBaseTest extends TestCase
{
    public function testFullBase()
    {
        $this->theme('bands/motorhead')->findOrCreate();

        $base = new Base();

        $ret = $base->empty();

        $this->assertFalse($ret);
    }

    public function testEmptyBase()
    {   
        $base = new Base();

        $ret = $base->empty();

        $this->assertTrue($ret);
    }
}