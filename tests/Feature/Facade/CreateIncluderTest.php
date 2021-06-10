<?php

namespace Maestriam\Samurai\Tests\Feature\Facade;

use Maestriam\Samurai\Support\Samurai;
use Maestriam\Samurai\Tests\TestCase;

class CreateIncluderTest extends TestCase
{
    public function testCreateIncluder()
    {
        $theme = 'bands/rainbow';

        $name = 'musics/lady-of-the-lake';

        $this->theme($theme)->findOrCreate();

        $includer = Samurai::theme($theme)->include($name)->create();

        $this->assertValidIncluder($includer);
    }
}