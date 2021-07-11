<?php

namespace Maestriam\Samurai\Tests\Unit\Entities\Composer;

use Maestriam\Samurai\Entities\Theme;
use Maestriam\Samurai\Tests\TestCase;
use Maestriam\Samurai\Entities\Composer;

class CreateComposerTest extends TestCase
{
    public function testCreateComposerFile()
    {
        $theme = new Theme('bands/wasp');

        $composer = new Composer($theme);

        $composer->create();

        $this->assertFileExists($composer->path());
    }
}