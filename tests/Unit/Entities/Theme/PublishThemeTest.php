<?php

namespace Maestriam\Samurai\Tests\Unit\Entities\Theme;

class PublishThemeTest extends ThemeTestCase
{
    public function testPublishTheme()
    {
        $theme = $this->theme('bands/kreator')->findOrCreate();

        $published = $theme->publish();

        $this->assertIsBool($published);
        $this->assertTrue($published);
        $this->assertDirectoryExists($theme->paths()->public());
    }
}