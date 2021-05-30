<?php

namespace Maestriam\Samurai\Tests\Unit\Entities\Vendor;

use Maestriam\Samurai\Entities\Vendor;
use Maestriam\Samurai\Entities\Wizard;
use Maestriam\Samurai\Tests\TestCase;
use stdClass;

/**
 * Testes de funcionalidades de definir/receber informações do vendor do tema
 */
class WizardTestCase extends TestCase
{
    /**
     * Verifica se consegue retorna a pergunta e sua resposta 
     * padrão sobre o vendor/nome-do-tema
     *
     * @return void
     */
    public function testThemeQuestion()
    {
        $wizard = new Wizard();

        $question = $wizard->theme();

        $this->assertInstanceOf(stdClass::class, $question);
        $this->assertObjectHasAttribute('ask', $question);
        $this->assertObjectHasAttribute('ask', $question);
        $this->assertIsString($question->ask);
        $this->assertIsString($question->default);
    }
}