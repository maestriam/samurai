<?php

namespace Maestriam\Samurai\Feature\Console;

use Str;
use Tests\TestCase;
use Maestriam\Samurai\Traits\Themeable;
use Illuminate\Support\Facades\Artisan;
use Maestriam\Samurai\Traits\ThemeTesting;
use Illuminate\Foundation\Testing\WithFaker;

class UseThemeCommandTest extends TestCase
{
    use Themeable, ThemeTesting, WithFaker;

    /**
     * Verifica se o comando para publicação de temas está OK
     *
     * @return voidUnit
     */
    public function testPublishTheme()
    {
        $theme = $this->themeName();

        $this->executeCommand($theme, 0);
    }

    /**
     * Executa o comando via console
     *
     * @param $name
     * @param $expected
     * @return void
     */
    public function executeCommand($name, $expected)
    {
        $this->theme($name)->findOrBuild();

        $command = sprintf('samurai:use %s', $name);

        $code = Artisan::call($command);

        $this->assertIsInt($code);
        $this->assertEquals($expected, $code);
    }
}