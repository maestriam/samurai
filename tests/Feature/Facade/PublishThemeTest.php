<?php

namespace Maestriam\Samurai\Tests\Feature\Facade;

use Maestriam\Samurai\Support\Samurai;
use Maestriam\Samurai\Tests\TestCase;

class PublishThemeTest extends TestCase
{
    public function testGetExistingTheme()
    {
        $name = 'bands/stage-dolls';

        $this->theme($name)->findOrCreate();

        $published = Samurai::theme($name)->publish();

        $this->assertIsBool($published);
        $this->assertTrue($published);
    }
}