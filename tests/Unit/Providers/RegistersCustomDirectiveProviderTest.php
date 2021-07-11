<?php

namespace Maestriam\Samurai\Tests\Unit\Providers;

use Maestriam\Samurai\Providers\RegistersCustomDirectiveProvider;
use Maestriam\Samurai\Tests\TestCase;

class RegistersCustomDirectiveProviderTest extends TestCase
{
    public function testService()
    {
        $this->theme('bands/led-zeppelin')->findOrCreate()->use();

        $provider = $this->app->register(RegistersCustomDirectiveProvider::class);

        $this->assertInstanceOf(RegistersCustomDirectiveProvider::class, $provider);
    }
}