<?php

namespace Maestriam\Samurai\Tests\Unit\Theme;

use Tests\TestCase;
use Maestriam\Samurai\Traits\Themeable;

/**
 * Testes de funcionalidades básicas apresentadas no README.md
 */
class PreviewThemeTest extends TestCase
{
    use Themeable;

    public function testPreview()
    {
        $vendor = 'maestriam/veq-theme';
        $author = 'Giu Foo <foo@gmail.com>';
        $desc   = 'A new happy theme! :)';

        $preview = $this->theme($vendor)
                        ->author($author)
                        ->description($desc)
                        ->preview();

        $this->assertIsString($preview);
        $this->assertJson($preview);
    }


    public function testPreviewAllDefault()
    {
        $vendor = 'maestriam/xasdw-theme';

        $preview = $this->theme($vendor)->preview();

        $this->assertIsString($preview);
        $this->assertJson($preview);
    }

    public function testPreviewWithDefaultDescription()
    {
        $vendor = 'maestriam/xasdw-theme';
        $author = 'Giu Foo <foo@gmail.com>';

        $preview = $this->theme($vendor)
                        ->author($author)
                        ->preview();

        $this->assertIsString($preview);
        $this->assertJson($preview);
    }
}
