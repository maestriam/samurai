<?php

namespace Maestriam\Samurai\Tests\Unit\Entities\Theme;

use Maestriam\Samurai\Entities\Theme;
use Maestriam\Samurai\Tests\Unit\Entities\Theme\ThemeTestCase;

/**
 * Testes de funcionalidades básicas apresentadas no README.md
 */
class ThemeAuthorTest extends ThemeTestCase
{
    public function testSetAuthor()
    {
        $theme = new Theme('xuxu/blog');

        $ret = $theme->author('Giuliano Sampaio <giuliano@gmail.com>');

        $this->assertInstanceOf(Theme::class, $ret);
        $this->assertIsString($ret->author()->name());
    }
}