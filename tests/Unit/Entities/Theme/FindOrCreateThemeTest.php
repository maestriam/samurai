<?php

namespace Maestriam\Samurai\Tests\Unit\Entities\Theme;

use Maestriam\Samurai\Entities\Theme;

class FindOrCreateThemeTest extends ThemeTestCase
{
    public function testFindOrCreate()
    {
        $theme = new Theme('bands/type-o-negative');

        $theme->findOrCreate();

        $this->assertValidTheme($theme);
    }
}