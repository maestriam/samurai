<?php

namespace Maestriam\Samurai\Feature\Console;

use Tests\TestCase;
use Illuminate\Support\Facades\Artisan;
use Maestriam\Samurai\Traits\Themeable;
use Illuminate\Foundation\Testing\WithFaker;

class PublishThemeCommandTest extends TestCase
{
    use Themeable, WithFaker;

    /**
     * Verifica se o comando para publicação de temas está OK
     *
     * @return void
     */
    public function testUseTheme()
    {
        $theme = $this->faker->word();

        $this->executeCommand($theme, 0);
    }

    /**
     * Executa o comando para publicar um tema via comando
     *
     * @param $name
     * @param $expected
     * @return void
     */
    private function executeCommand($name, $expected)
    {
        $this->theme($name)->findOrBuild();

        $command = sprintf("samurai:publish %s", $name);

        $code = Artisan::call($command);

        $this->assertIsInt($code);
        $this->assertEquals($expected, $code);
    }
}
