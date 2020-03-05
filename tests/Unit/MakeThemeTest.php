<?php

namespace Maestriam\Samurai\Tests\Unit;

use Tests\TestCase;
use Illuminate\Support\Str;
use Maestriam\Samurai\Models\Theme;
use Illuminate\Support\Facades\Config;
use Maestriam\Samurai\Traits\Themeable;
use Illuminate\Foundation\Testing\WithFaker;
use Maestriam\Samurai\Exceptions\InvalidThemeNameException;

/**
 * Testes de funcionalidades básicas apresentadas no README.md
 */
class MakeThemeTest extends TestCase
{
    use Themeable, WithFaker;

    protected $name;

    /**
     * Undocumented function
     *
     * @return void
     */
    public function testHappyPath()
    {
        $name  = Str::random(50);

        $this->contestSuccess($name);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function testNameStartNumbers()
    {
        $name = time() . Str::random(50);

        $this->contestInvalidName($name);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function testUpperCaseName()
    {
        $name = strtoupper(Str::random(40));

        $this->contestSuccess($name);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    public function testSpecialChars()
    {
        $name = "sp&c/al-ch@r$-t()&m&";

        $this->contestInvalidName($name);
    }

    /**
     * Undocumented function
     *
     * @param [type] $name
     * @return void
     */
    private function contestSuccess($name)
    {
        $theme = $this->theme($name)->build();

        $this->contestObject($theme);
        $this->contestPath($theme->path);
        $this->contestName($theme->name);
        $this->contestNamespace($theme->namespace);
    }

    /**
     * Undocumented function
     *
     * @param [type] $theme
     * @return void
     */
    private function contestObject($theme)
    {
        $this->assertInstanceOf(Theme::class, $theme);
        $this->assertObjectHasAttribute('path', $theme);
        $this->assertObjectHasAttribute('name', $theme);
        $this->assertObjectHasAttribute('namespace', $theme);
    }

    /**
     * Undocumented function
     *
     * @param [type] $name
     * @return void
     */
    private function contestName($name)
    {
        $lower = strtolower($name);

        $this->assertStringContainsString($lower, $name, '', true);
    }

    /**
     * Undocumented function
     *
     * @param [type] $path
     * @return void
     */
    private function contestPath($path)
    {
        $this->assertIsString($path);
        $this->assertDirectoryExists($path);
        $this->assertDirectoryIsReadable($path);
        $this->assertDirectoryIsWritable($path);
    }

    /**
     * Undocumented function
     *
     * @param [type] $namespace
     * @return void
     */
    private function contestNamespace($namespace)
    {
        $prefix  = Config::get('Samurai::prefix');
        $pattern = "/$prefix/";

        $this->assertRegExp($pattern, $namespace);
    }

    /**
     * Undocumented function
     *
     * @param [type] $name
     * @return void
     */
    private function contestInvalidName($name)
    {
        $this->expectException(InvalidThemeNameException::class);

        $this->theme($name)->build();
    }
}
