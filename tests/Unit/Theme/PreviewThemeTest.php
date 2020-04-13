<?php

namespace Maestriam\Samurai\Tests\Unit\Theme;

use Tests\TestCase;
use Maestriam\Samurai\Traits\Themeable;
use Illuminate\Foundation\Testing\WithFaker;
use Maestriam\Samurai\Traits\Testing\FakeValues;

/**
 * Testes de funcionalidades básicas apresentadas no README.md
 */
class PreviewThemeTest extends TestCase
{ 
    use WithFaker, FakeValues, Themeable;

    /**
     * Verifica se consegue exibir a prévia do Json 
     * com sucesso
     *
     * @return void
     */
    public function testPreview()
    {
        $vendor = $this->fakeTheme();
        $author = $this->fakeAuthor();
        $desc   = $this->fakeDescription();

        $preview = $this->theme($vendor)
                        ->author($author)
                        ->description($desc)
                        ->preview();

        $this->success($preview);
    }

    /**
     * Verifica se consegue exibir a prévia do Json 
     * passando apenas o nome do tema
     *
     * @return void
     */
    public function testPreviewAllDefault()
    {
        $theme   = $this->fakeTheme();
        $preview = $this->theme($theme)->preview();
        
        $this->success($preview);
    }

    /**
     * Verifica se consegue exibir a prévia do Json 
     * passando o nome do tema e o autor
     *
     * @return void
     */
    public function testPreviewWithDefaultDescription()
    {
        $theme  = $this->fakeTheme();
        $author = $this->fakeAuthor();

        $preview = $this->theme($theme)
                        ->author($author)
                        ->preview();
    
        $this->success($preview);
    }

    /**
     * Verifica se consegue exibir a prévia do Json 
     * passando o nome do tema e a descrição
     *
     * @return void
     */
    public function testPreviewWithDefaultAuthor()
    {
        $theme = $this->fakeTheme();
        $desc  = $this->fakeDescription();

        $preview = $this->theme($theme)
                        ->description($desc)
                        ->preview();

        $this->success($preview);
    }

    /**
     * Undocumented function
     *
     * @param [type] $preview
     * @return void
     */
    private function success($preview)
    {
        $this->assertIsString($preview);
        $this->assertJson($preview);
    }
}
