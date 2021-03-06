<?php

namespace Maestriam\Samurai\Tests\Unit\Providers;

use Maestriam\Samurai\Providers\RegistersThemesProvider;
use Maestriam\Samurai\Tests\TestCase;

class RegistersThemesProviderTest extends TestCase
{
    public function testService()
    {
        $this->theme('bands/pantera')->findOrCreate()->use();

        $provider = $this->app->register(RegistersThemesProvider::class);

        $this->assertInstanceOf(RegistersThemesProvider::class, $provider);
    }
}