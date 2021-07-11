<?php

namespace Maestriam\Samurai\Tests\Feature\Facade;

use Maestriam\Samurai\Support\Samurai;
use Maestriam\Samurai\Tests\TestCase;

class CreateComponentTest extends TestCase
{
    public function testCreateComponent()
    {
        $theme = 'bands/rainbow';

        $name = 'lady-of-the-lake';

        $this->theme($theme)->findOrCreate();

        $component = Samurai::theme($theme)->component($name)->create();

        $this->assertValidComponent($component);
    }
}