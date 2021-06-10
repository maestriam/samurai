<?php

namespace Maestriam\Samurai\Tests\Feature\Console;

use Maestriam\Samurai\Exceptions\InvalidThemeNameException;
use Maestriam\Samurai\Tests\TestCase;

class PublishThemeCommandTest extends TestCase
{    
    public function testPublishValidTheme()
    {
        $theme = 'bands/sodom';

        $this->theme($theme)->findOrCreate();

        $cmd = sprintf("samurai:publish %s", $theme);

        $this->artisan($cmd)->assertExitCode(0);
    }
}