<?php

namespace Maestriam\Samurai\Tests\Unit\Providers\RegistersThemesProvider;

use Maestriam\Samurai\Providers\RegistersThemesProvider;
use Maestriam\Samurai\Tests\TestCase;

class RegistersThemesProviderTest extends TestCase
{
    public function testService()
    {
        $this->theme('bands/pantera')->findOrCreate()->use();

        $this->app->register(RegistersThemesProvider::class);
        
    }
}